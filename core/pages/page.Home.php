<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Home implements iPage
{
    public static function display( $action = null, $arg = null)
    {
        ob_clean();
        ob_start();
        
        Components::bootstrap();
        Components::css( __CLASS__ );
        Components::navbar( __CLASS__ );
        ?>

            <div class="container centered col-sm-6">
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload">

                    <div class="upload-form-field">
                        <label for="upload-form-message">Your hidden message</label>
                        <input class="form-control" id="upload-form-message" type="text" name="message" placeholder="Message" required autocomplete="off">
                    </div>
                    &nbsp;
                    <div class="upload-form-field">
                        <label for="upload-form-file">Wav File</label>
                        <input class="form-control" id="upload-form-file" type="file" name="stegfile" required>
                    </div>

                    <div class="upload-form-field">
                        <label for="upload-form-action-type">Action</label>
                        <select class="form-control" name="actiontype" id="upload-form-action-type" required>
                            <option value="" disabled selected>-- Select action type --</option>
                            <option value="hide">Hide the message in the file</option>
                            <option value="extract">Extract the message out of the file</option>
                        </select>
                    </div>

                    <div class="upload-form-field">
                        <input type="submit" value="Upload">
                    </div>
                </form>
            </div>
        <?php

        Components::javascript( __CLASS__ );
        die;
    }
}