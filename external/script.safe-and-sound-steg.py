import getopt, os, sys, math, struct, wave

def usage():
    print("Usage options:\n")
    print("     --help                  Display help\n")
    print("     --hide                  'Hide data' option\n")
    print("     --extract               'Extract data' option\n")
    print("     --file [filename]       This option specifies the WAV file that will be used for hiding / extracting data\n")
    print("     --secret [filename]     In case of 'hide data' option, [filename] will contain the message that will be embedded in the .wav file\n")
    print("     --output [filename]     Output file\n")
    print("     --lsb-count [count]     Number of Least Significant Bits to use\n")
    print("'Hide' usage ex:             python safe-and-sound-steg.py --hide    --file [wavfile.wav]                --output [outWav.wav]       --lsb-count 2 --secret [data.txt] ")
    print("'Extract' usage ex:          python safe-and-sound-steg.py --extract --file [wavWithSecretMessage.wav]   --output [outputTxt.txt]    --lsb-count 2")

def isReadable(asciiCode):
    return (asciiCode >= 65 and asciiCode <= 90) or (asciiCode >= 97 and asciiCode <= 122) or (asciiCode >= 48 and asciiCode <= 57) or (asciiCode == 32) or (asciiCode in [44, 46, 63, 33, 10, 13, 39])

def prepare(wavFilename, secretFilename, outputWavFilename, lsbCount):
    soundFile = wave.open(wavFilename, "r")
    
    soundFileParameters     = soundFile.getparams()     
    channelCount            = soundFile.getnchannels()  
    sampleWidth             = soundFile.getsampwidth()  
    frameCount              = soundFile.getnframes()    
    sampleCount             = frameCount * channelCount 

    if (sampleWidth == 1):  
        
        fmt             = "{}B".format(sampleCount)
        mask            = (1 << 8) - (1 << lsbCount)   
        smallestByte    = -(1 << 7)            
    
    elif (sampleWidth == 2):  
        
        fmt             = "{}h".format(sampleCount)
        mask            = (1 << 15) - (1 << lsbCount)  
        smallestByte    = -(1 << 15)           
    
    else:
        raise ValueError("File has an unsupported bit-depth")

    params                          = dict()
    params['soundFile']             = soundFile
    params['soundFileParameters']   = soundFileParameters
    params['frameCount']            = frameCount
    params['sampleCount']           = sampleCount
    params['fmt']                   = fmt
    params['mask']                  = mask
    params['smallestByte']          = smallestByte
    params['wavFilename']           = wavFilename
    params['secretFilename']        = secretFilename
    params['outputWavFilename']     = outputWavFilename
    params['lsbCount']              = lsbCount

    return params

def stegEnc(params):
    
    wavFilename             = params['wavFilename']
    secretFilename          = params['secretFilename']
    outputWavFilename       = params['outputWavFilename']
    lsbCount                = params['lsbCount']
    soundFile               = params['soundFile']
    soundFileParameters     = params['soundFileParameters']
    frameCount              = params['frameCount']
    sampleCount             = params['sampleCount']
    fmt                     = params['fmt'] 
    mask                    = params['mask']
    smallestByte            = params['smallestByte']

    bytesToHideMaxCount     = (sampleCount * lsbCount) // 8
    filesize                = os.stat(secretFilename).st_size
    
    if (filesize > bytesToHideMaxCount):
        requiredLSBs = math.ceil(filesize * 8 / sampleCount)
        raise ValueError("Input file too large to hide, requires {} LSBs, using {}".format(requiredLSBs, lsbCount))
    
    print("Using {} B out of {} B".format(filesize, bytesToHideMaxCount))
    
    
    rawData = list(struct.unpack(fmt, soundFile.readframes(frameCount)))
    soundFile.close()
    
    inputData               = memoryview(open(secretFilename, "rb").read())
    dataIndex               = 0
    soundIndex              = 0
    
    alteredSoundFileData    = []
    buffer                  = 0
    bufferLength            = 0
    done                    = False
    
    while(not done):

        while (bufferLength < lsbCount and dataIndex // 8 < len(inputData)):
            buffer          += (ord(inputData[dataIndex // 8]) >> (dataIndex % 8)) << bufferLength
            bitsAdded       = 8 - (dataIndex % 8)
            bufferLength    += bitsAdded
            dataIndex       += bitsAdded
            
        currentData     = buffer % (1 << lsbCount)
        buffer          >>= lsbCount
        bufferLength    -= lsbCount

        while (soundIndex < len(rawData) and rawData[soundIndex] == smallestByte):
            alteredSoundFileData.append(struct.pack(fmt[-1], rawData[soundIndex]))
            soundIndex += 1

        if (soundIndex < len(rawData)):
            currentSample   = rawData[soundIndex]
            soundIndex      += 1

            sign = 1
            if (currentSample < 0):
                currentSample   = -currentSample
                sign            = -1


            alteredSample = sign * ((currentSample & mask) | currentData)
            alteredSoundFileData.append(struct.pack(fmt[-1], alteredSample))

        if (dataIndex // 8 >= len(inputData) and bufferLength <= 0):
            done = True
        
    while(soundIndex < len(rawData)):
        alteredSoundFileData.append(struct.pack(fmt[-1], rawData[soundIndex]))
        soundIndex += 1
    
    soundSteg = wave.open(outputWavFilename, "w")
    soundSteg.setparams(soundFileParameters)
    soundSteg.writeframes(b"".join(alteredSoundFileData))
    soundSteg.close()
    print("Data hidden over {} audio file".format(outputWavFilename))

def stegDec(params):

    extractionEnded     = False
    wavFilename         = params['wavFilename']
    outputWavFilename   = params['outputWavFilename']
    lsbCount            = params['lsbCount']
    soundFile           = params['soundFile']
    frameCount          = params['frameCount']
    sampleCount         = params['sampleCount']
    fmt                 = params['fmt'] 
    smallestByte        = params['smallestByte']

    rawData             = list(struct.unpack(fmt, soundFile.readframes(frameCount)))

    mask                = (1 << lsbCount) - 1
    outputFile          = open(outputWavFilename, "wb+")

    data                = bytearray()
    soundIndex          = 0 
    buffer              = 0
    bufferLength        = 0
    soundFile.close()

    while not extractionEnded:
        
        nextSample = rawData[soundIndex]
        if (nextSample != smallestByte):
            buffer          += (abs(nextSample) & mask) << bufferLength
            bufferLength    += lsbCount

        soundIndex += 1
        
        while (bufferLength >= 8):
            currentData     = buffer % (1 << 8)

            if not isReadable(ord(struct.pack('1B', currentData))):
                extractionEnded = True
                break

            buffer          >>= 8
            bufferLength    -= 8
            data            += struct.pack('1B', currentData)

            print("{}".format(struct.pack('1B', currentData))),

    outputFile.write(bytes(data))
    outputFile.close()
    print('')
    print("Data recovered to file \"{}\".".format(outputWavFilename))



try:
    wavFilename = secretFilename = outputWavFilename = lsbCount = bytesToRecover = None

    opts, args = getopt.getopt(sys.argv[1:], 'hrs:d:o:n:b:',
                              ['hide', 'extract', 'file=', 'secret=',
                               'output=', 'lsb-count=', 'byte-count=', 'help'])

except getopt.GetoptError:
    usage()
    sys.exit(1)

hideAction      = False
extractAction   = False
mandatoryParams = {
    'optAction':            False,
    'optFile':              False,
    'optFilename':          False,
    'optOutput':            False,
    'optOutputFilename':    False,
    'optLSB':               False,
    'optLSBCount':          False
}

for opt, arg in opts:
    if opt in ("--hide"):
        hideAction = True
        mandatoryParams['optAction'] = True

    elif opt in ("--extract"):
        extractAction = True
        mandatoryParams['optAction'] = True

    elif opt in ("--file"):
        wavFilename = arg
        if arg != '':
            mandatoryParams['optFilename'] = True
        mandatoryParams['optFile'] = True

    elif opt in ("--secret"):
        secretFilename = arg

    elif opt in ("--output"):
        outputWavFilename = arg
        if arg != '':
            mandatoryParams['optOutputFilename'] = True
        mandatoryParams['optOutput'] = True

    elif opt in ("--lsb-count"):
        lsbCount = int(arg)
        if str(arg) != '':
            mandatoryParams['optLSBCount'] = True
        mandatoryParams['optLSB'] = True

    elif opt in ("--help"):
        usage()
        sys.exit(1)

    else:
        print("Invalid argument {}".format(opt))

try:
    for option in mandatoryParams:
        if not mandatoryParams[option]:
            raise Exception('Invalid parameters: "' + option + '" parameter missing')

    params = prepare(wavFilename, secretFilename, outputWavFilename, lsbCount)

    if (hideAction):
        stegEnc(params)

    if (extractAction):
        stegDec(params)

except Exception as e:
    print("Exception occured: ")
    print(e)
    usage()
    sys.exit(1)