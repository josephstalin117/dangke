<?php

//视频播放记录
require_once 'logincheck.php';
$userUpdate["VIDEO_LEARNED"] = isset($_POST["videoid"]) ? $_POST["videoid"] : '';
if ($userUpdate["VIDEO_LEARNED"] != NULL) {
    $videoLearned = explode(",", $userInfo["VIDEO_LEARNED"]);
    if (!in_array($userUpdate["VIDEO_LEARNED"], $videoLearned)) {
        $userUpdate["VIDEO_LEARNED"] = $userInfo["VIDEO_LEARNED"] . $userUpdate["VIDEO_LEARNED"] . ',';
        $db->update("stuinfo", $userUpdate, "ID=$userInfo[ID]");
    }
}
?>