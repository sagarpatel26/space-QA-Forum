<?php
include_once("scripts/classes/_user.php");
include_once("scripts/classes/_questions.php");
include_once("scripts/classes/_answers.php");
session_start();
if (!isset($_SESSION['uid']))
{
    header('Location: LoginRegistrationForm/login.php');
    die("user not logged in");
}
else
{
    if (isset($_SESSION['uid'])){
        $uid = $_SESSION['uid'];
    }
    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    if (isset($_SESSION['qoffset'])){
        $qoffset = $_SESSION['qoffset'];
    }
    require_once("tmpl/index-above-questions-list.tmpl");

    $quesarr = _question::_get_all_question_by_date();
    if (!$quesarr) {
        header("Location: error.php");
        die();
    }
    $q = new _question();
    foreach ($quesarr as $q) { ?>
        <div class="question-block">

            <div class="question">
                <div class="question-description">
                    <table class="Q-aligner">
                        <tr>
                            <td>Q: </td>
                            <td><?php echo $q->getDescription();?></td>
                        </tr>
                    </table>
                </div>
                <div class="question-button-panel">
                    <input type="hidden" value="<?php echo $q->getQid();?>">
                    <button class="btn btn-warning btn-xs my-qbuttons"><span class="badge"><?php echo $q->getCurious();?></span></button>
                    <?php
                    $quser = new _user();
                    $quser->_get_fdb_ref_uid($q->getQUid());
                    ?>
                    <span class="question-user">Asked by: <a href="profile.php?username=<?php echo $quser->getUsername();?>"><?php echo $quser->getUsername();?></a> on <?php echo $q->getQTime();?></span>

                </div>

            </div>

            <div class="answer-slider">double click to see answer(s)</div>
            <div class="answer">

                <?php
                $ansarr = _answers::_get_all_answer_by_qid($q->getQid());
                $ans = new _answers();
                if (count($ansarr)==0)
                    echo "Sorry No Answers Yet!!";
                foreach ($ansarr as $ans) { ?>
                <div class="answer-description">
                    <table class="Q-aligner">
                        <tr>
                            <td>A: </td>
                            <td><?php echo $ans->getDescription();?></td>
                        </tr>
                    </table>
                </div>
                <div class="answer-button-panel">
                    <input type="hidden" value="<?php echo $ans->getAid();?>">
                    <button class="btn btn-success btn-xs my-abuttonsapt"><span class="badge"><?php echo $ans->getApt();?></span></button>
                    <button class="btn btn-danger btn-xs my-abuttonsnotapt"><span class="badge"><?php echo $ans->getNotApt();?></span></button>
                    <?php
                        $ansuser = new _user();
                        $ansuser->_get_fdb_ref_uid($ans->getAUid());
                    ?>
                    <span class="answer-user">Answer by: <a href="profile.php?username=<?php echo $ansuser->getUsername();?>"><?php echo $ansuser->getUsername();?></a> on <?php echo $ans->getATime();?></span>
                </div>
                <?php }?>
            </div>

            <div class="answer-question">
                <a class="displayAnswerQuestionBlock" href="javascript:void(0)">Answer this Question.</a>
                <div class="answer-question-block">
                    <form method="post" action="scripts/addnewanswer.php">
                        <input type="hidden" name="qid" value="<?php echo $q->getQid();?>" />
                        <textarea rows="10" col="200" name="ad" placeholder="your valuable answer goes over here...." required></textarea>
                        <input type="submit" value="Post it!"/>
                    </form>
                    <a  class="hideAnswerQuestionBlock" href="javascript:void(0)">cancel</a>
                </div>
            </div>

        </div>

    <?php }

    require_once("tmpl/index-below-questions-list.tmpl");
}