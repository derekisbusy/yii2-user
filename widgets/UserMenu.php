<?php

/**
 * @copyright Copyright &copy; communityii, 2014
 * @package yii2-user
 * @version 1.0.0
 * @see https://github.com/communityii/yii2-user
 */

namespace comyii\user\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Nav;
use comyii\user\Module;

/**
 * User profile actions menu
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class UserMenu extends Nav
{
    /**
     * @var integer the user id
     */
    public $user;
    
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = false;
    
    /**
     * @var string the user interface currently being rendered
     */
    public $ui;

    /**
     * @inheritdoc
     */
    public $options = ['class' => 'nav-pills'];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $m = Yii::$app->getModule('user');
        $currUser = Yii::$app->user;
        if ($currUser->id == $this->user) {
            $this->items = [
                [
                   'label' => $m->icon('eye-open') . Yii::t('user', 'View'),
                   'url' => [$m->actionSettings[Module::ACTION_PROFILE_INDEX]],
                   'active' => ($this->ui === 'view'),
                   'linkOptions' => ['title' => Yii::t('user', 'View user profile')]
                ],
                [
                   'label' => $m->icon('pencil') . Yii::t('user', 'Edit'),
                   'url' => [$m->actionSettings[Module::ACTION_PROFILE_EDIT]],
                   'active' => ($this->ui === 'edit'),
                   'linkOptions' => ['title' => Yii::t('user', 'Edit user profile')]
                ],
                [
                   'label' => $m->icon('lock') . Yii::t('user', 'Password'),
                   'url' => [$m->actionSettings[Module::ACTION_ACCOUNT_PASSWORD]],
                   'active' => ($this->ui === 'password'),
                   'linkOptions' => ['title' => Yii::t('user', 'Change user password')]
                ],
            ];
        }
        if ($currUser->isAdmin || $currUser->isSuperuser) {
            $this->items = ArrayHelper::merge([
                [
                   'label' => $m->icon('wrench') . Yii::t('user', 'Manage'),
                   'url' => [$m->actionSettings[Module::ACTION_ADMIN_MANAGE], 'id' => $this->user],
                   'linkOptions' => ['title' => Yii::t('user', 'Administer user profile')]
                ],
            ], $this->items);
        }
        parent::init();
    }
}