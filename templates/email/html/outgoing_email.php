<?php

use Cake\Core\Configure;

$this->assign('title', __('Packet Delivered'));

$appName = Configure::readOrFail('App.name');

$this->assign('preheader', __('You have received a packet from {0}.', $appName));

// Generate login URL
$linkUrl = $this->Url->build([
    '_name' => 'login'
], [
    'fullBase' => true
]);
?>

<!-- Your HTML code for the "Packet Delivered" template -->
<div style="background-color: rgb(236, 254, 254);" align="center">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="text-align: center;">
                <img style="left: 35%; width: 20%; height: 60px;" src="https://i.ibb.co/6JC7mL7/revkeep-logo.png" alt="RevKeep">
            </td>
        </tr>
        <br>
        <br>

        <div style="background-color: white; width: 90%; margin-left: 5%;">
            <br>
            <h2 style="font-family: 'Poppins', sans-serif; color: rgba(53, 157, 158, 1); text-align: center;">Packet Delivered</h2>
            <h3 style="text-align: center;">Hi <strong><?= $fullname ?></strong>,</h3>

            <p align='center' class="mb-2">You have received a packet.</p>
            <p align='center' class="mb-2">Kindly check the delivered packet and acknowledge the receipt.</p>
            <p align='center' class="mb-2">Login to RevKeep to view details: <a href="<?= $linkUrl; ?>" target="_blank"><?= $linkUrl; ?></a></p>
            <p align='center' class="text-muted">
                Thanks & Regards
            </p>
        </div>
        <hr />
    </div>
</div>
