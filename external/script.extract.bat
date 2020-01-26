set stegfile=%1
shift
set outputfile=%1
shift
set lsbcount=%1
shift
python script.safe-and-sound-steg.py --extract --file %stegfile% --output %outputfile% --lsb-count %lsbcount%