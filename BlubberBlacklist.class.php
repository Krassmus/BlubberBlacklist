<?php

class BlubberBlacklist extends StudIPPlugin implements SystemPlugin
{
    public function __construct()
    {
        parent::__construct();
        if (RolePersistence::isAssignedRole($GLOBALS['user']->id, "BlubberBlacklist")) {
            if (Navigation::hasItem('/community/blubber')) {
                Navigation::removeItem('/community/blubber');
            }
            if (Navigation::hasItem('/course/blubber')) {
                Navigation::removeItem('/course/blubber');
            }
            if (stripos($_SERVER['REQUEST_URI'], "dispatch.php/blubber") !== false) {
                $blubber = BlubberGlobalThread::find('global');
                $blubber->removeFollowingByUser();
                throw new AccessDeniedException();
            }
            if ((stripos($_SERVER['REQUEST_URI'], "plugins.php/blubber") !== false) || (stripos($_SERVER['REQUEST_URI'], "api.php/blubber") !== false)) {
                throw new AccessDeniedException();
            }
        }
    }
}
