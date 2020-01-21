<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Home implements iPage
{
    public static function display()
    {
        ob_clean();

        ?>
            <form id="upload-form" action="index.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload" />
                <input type="textarea" placeholder="Your hidden message" name="hide_message" autocomplete="off" />
                <br/>
                <input type="file" name="upload_file">
                <br/>
                <input type="submit" />
            </form>
            <br/>
            
            <form id="upload-form" action="index.php">
                <input type="hidden" name="action" value="about" />
                <input type="submit" value="About" />
            </form>

            <style>
                #upload-form {
                    text-align: center;
                    margin-top: 100px;
                }
                #upload-form input {
                    padding-top: 10px;
                    margin-top: 100px;
                }
            </style>
        <?php
        die;
    }
}