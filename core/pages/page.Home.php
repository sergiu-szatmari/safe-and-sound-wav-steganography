<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Home implements iPage
{
    public static function display()
    {
        ob_clean();
        ob_start();
        
        Components::bootstrap();
        Components::navbar( __CLASS__ );
        ?>

            <div class="container centered col-sm-6">
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload" >
                    <input type="text" name="message" placeholder="Your hidden message" required>
                    <input type="file" name="stegfile" required>
                    <input type="submit" value="Upload">
                </form>
            </div>

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