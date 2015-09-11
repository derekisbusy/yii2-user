<?php
/**
 * @copyright Copyright &copy; Kartik Visweswaran, 2014 - 2015
 * @package communityii/yii2-user
 * @version 1.0.0
 * @see https://github.com/communityii/yii2-user
 */

use yii\helpers\Html;
use yii\helpers\Url;
use comyii\user\Module;

/* @var $this yii\web\View */
/* @var $user common\models\User */
$m = Yii::$app->getModule('user');
$action = $m->actionSettings[Module::ACTION_ACTIVATE];
$activateLink = Url::to([$action, 'key' => $user->activation_key], true);
$name = Yii::$app->name;
?>

<p>Hello <b><?= Html::encode($user->username) ?></b>,</p>

<p>Thank you for registering at <b><?= $name ?></b>. Follow the link below to activate your account:</p>

<blockquote><?= Html::a(Html::encode($activateLink), $activateLink) ?></blockquote>

<?php if (!empty($timeLeft)): ?>
    <p><em><b>Note</b>: <?= $timeLeft ?></em></p>
<?php endif; ?>

<p>Regards,</p>

<p>Administrator</p>

<p><b><?= Yii::$app->name ?></b></p>
