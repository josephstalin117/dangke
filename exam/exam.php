<?php

class exam {

    function examBefore($examEndTime) {
        if ($examEndTime < time()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function examCheckTicke($examEndTime, $stuSco, $chapter, $examChapter) {
        try {
            $chapterComplete = explode(",", $examChapter);
            if ($examEndTime < time()) {
                throw new Exception("考试时间已截止");
            } elseif ($stuSco != NULL) {
                throw new Exception("本章已经有成绩了");
            } elseif (in_array($chapter, $chapterComplete)) {
                throw new Exception("您已经完成了此章考试");
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //分章节抽题
    function examSelect($singleId, $multiId, $judgeId, $db) {
        try {
            if ($singleId || $multiId || $judgeId) {
                return FALSE;
                //做到这里
            }
            
            
        } catch (Exception $ex) {
            
        }
    }

    function examGet() {
        
    }

    function examTimeCheck() {
        
    }

    //Save temporary submit
    function examSave() {
        
    }

    function examCheckPaper() {
        //To-do
        //userLogin
        //question number
        //exam submit
        //student score
    }

    function examCalcuResult() {
        
    }

    function examScoreSubmit() {
        
    }

}

?>
