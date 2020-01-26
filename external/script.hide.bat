set secretfile=%1
shift
set stegfile=%1
shift
set outputfile=%1
shift
set lsbcount=%1
shift
python script.safe-and-sound-steg.py --hide --secret %secretfile% --file %stegfile% --output %outputfile% --lsb-count %lsbcount%