<?php
/**
 * sagarpatel
 * Date: 15-Mar-15
 * Time: 8:42 PM
 */

include_once('_database.php');

class _answers
{
    private $_aid;
    private $_a_uid;
    private $_a_qid;
    private $_description;
    private $_apt;
    private $_notapt;
    private $_a_time;

    function __construct()
    {
        $this->_aid = null;
        $this->_a_uid = null;
        $this->_a_qid = null;
        $this->_description = null;
        $this->_apt = 0;
        $this->_notapt = 0;
        $this->_a_time = null;
    }

    /**
     * @return null
     */
    public function getAQid()
    {
        return $this->_a_qid;
    }

    /**
     * @param null $a_qid
     */
    public function setAQid($a_qid)
    {
        $this->_a_qid = $a_qid;
    }

    /**
     * @return null
     */
    public function getATime()
    {
        return $this->_a_time;
    }

    /**
     * @param null $a_time
     */
    public function setATime($a_time)
    {
        $this->_a_time = $a_time;
    }

    /**
     * @return null
     */
    public function getAUid()
    {
        return $this->_a_uid;
    }

    /**
     * @param null $a_uid
     */
    public function setAUid($a_uid)
    {
        $this->_a_uid = $a_uid;
    }

    /**
     * @return null
     */
    public function getAid()
    {
        return $this->_aid;
    }

    /**
     * @param null $aid
     */
    public function setAid($aid)
    {
        $this->_aid = $aid;
    }

    /**
     * @return null
     */
    public function getApt()
    {
        return $this->_apt;
    }

    /**
     * @param null $apt
     */
    public function setApt($apt)
    {
        $this->_apt = $apt;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * @return null
     */
    public function getNotapt()
    {
        return $this->_notapt;
    }

    /**
     * @param null $notapt
     */
    public function setNotapt($notapt)
    {
        $this->_notapt = $notapt;
    }



    function _get_fdb_aid($_ref_aid)
    {
        $connection = _database::get_connection();
        $query = "SELECT * FROM `_answers` WHERE `_aid`=$_ref_aid";

        $result = $connection->query($query);

        if ($result->num_rows>0)
        {
            $result_array = $result->fetch_assoc();
            $this->_aid = $result_array['_aid'];
            $this->_a_uid = $result_array['_a_uid'];
            $this->_a_qid = $result_array['_a_qid'];
            $this->_description = $result_array['_description'];
            $this->_apt = $result_array['_apt'];
            $this->_notapt = $result_array['_notapt'];
            $this->_a_time = $result_array['_a_time'];

            return true;
        }
        else {
            return false;
        }
    }

    function _insert_db()
    {
        $connection = _database::get_connection();
        $this->_a_time = date('d-m-Y');
        $query = "INSERT INTO `_answers`(`_description`, `_a_uid`, `_a_qid`, `_apt`, `_notapt`, `_a_time`) VALUES ('$this->_description',$this->_a_uid,$this->_a_qid,$this->_apt,$this->_notapt,now());";
        if ($connection->query($query)==true)
        {
            return true;
        }
        echo $connection->error;
        return false;
    }

    static function _chng_apt($_ref_aid,$incruid)
    {
        $connection = _database::get_connection();
        $ans = new _answers();
        $ans->_get_fdb_aid($_ref_aid);

        $checkq = "SELECT `_notapt`,`_apt` FROM `_aiduid` WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
        $res=$connection->query($checkq);
        if ($res->num_rows>0)
        {
            $arr = $res->fetch_array();
            if ($arr['_notapt']==1) {
                return $ans;
            }
            if ($arr['_apt']==1)
            {
                $updq = "UPDATE `_aiduid` SET `_apt`= 0 WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
                if ($connection->query($updq))
                {
                    $ans->_dcr_apt();
                    return $ans;
                }
                else
                    return null;
            }
            else
            {
                $updq = "UPDATE `_aiduid` SET `_apt`= 1 WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
                if ($connection->query($updq))
                {
                    $ans->_incr_apt();
                    return $ans;;
                }
                else
                    return null;
            }
        }
        else
        {
            $instq = "INSERT INTO `_aiduid`(`_uid`, `_aid`, `_notapt`, `_apt`) VALUES ($incruid,$ans->_aid,0,1)";
            if ($connection->query($instq))
            {
                $ans->_incr_apt();
                return $ans;
            }
            else
                return null;
        }
    }


    static function _chng_notapt($_ref_aid,$incruid)
    {
        $connection = _database::get_connection();
        $ans = new _answers();
        $ans->_get_fdb_aid($_ref_aid);
        $checkq = "SELECT `_apt`,`_notapt` FROM `_aiduid` WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
        $res=$connection->query($checkq);
        if ($res->num_rows>0)
        {
            $arr = $res->fetch_array();
            if ($arr['_apt']==1) {
                return $ans;
            }
            if ($arr['_notapt']==1)
            {
                $updq = "UPDATE `_aiduid` SET `_notapt`= 0 WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
                if ($connection->query($updq))
                {
                    $ans->_dcr_notapt();
                    return $ans;
                }
                else
                    return null;
            }
            else
            {
                $updq = "UPDATE `_aiduid` SET `_notapt`= 1 WHERE `_uid` = $incruid AND `_aid` = $ans->_aid";
                if ($connection->query($updq))
                {
                    $ans->_incr_notapt();
                    return $ans;
                }
                else
                    return null;
            }
        }
        else
        {
            $instq = "INSERT INTO `_aiduid`(`_uid`, `_aid`, `_notapt`, `_apt`) VALUES ($incruid,$ans->_aid,1,0)";
            if ($connection->query($instq))
            {
                $ans->_incr_notapt();
                return $ans;
            }
            else
                return null;
        }
    }

    function _incr_apt()
    {
        $connection = _database::get_connection();
        $this->_apt++;

        $query = "UPDATE `spacev0.0`.`_answers` SET `_apt` = $this->_apt WHERE `_answers`.`_aid` = $this->_aid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    function _dcr_apt()
    {
        $connection = _database::get_connection();
        $this->_apt--;

        $query = "UPDATE `spacev0.0`.`_answers` SET `_apt` = $this->_apt WHERE `_answers`.`_aid` = $this->_aid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    function _incr_notapt()
    {
        $connection = _database::get_connection();
        $this->_notapt++;
        $query = "UPDATE `spacev0.0`.`_answers` SET `_notapt` = $this->_notapt WHERE `_answers`.`_aid` = $this->_aid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    function _dcr_notapt()
    {
        $connection = _database::get_connection();
        $this->_notapt--;
        $query = "UPDATE `spacev0.0`.`_answers` SET `_notapt` = $this->_notapt WHERE `_answers`.`_aid` = $this->_aid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    /**
     *  gets all answers for the the given qid
     */
    public static function _get_all_answer_by_qid($ref_qid)
    {
        $all_answers = array();
        $connection = _database::get_connection();
        $query = "SELECT * FROM `_answers` WHERE `_a_qid` = $ref_qid ORDER BY `_a_time` DESC";
        if ($res = $connection->query($query)) {
            $i=0;
            while ($arr = $res->fetch_array())
            {
                $obj = new _answers();
                $obj->setAid($arr['_aid']);
                $obj->setDescription($arr['_description']);
                $obj->setAUid($arr['_a_uid']);
                $obj->setAQid($arr['_a_qid']);
                $obj->setApt($arr['_apt']);
                $obj->setNotApt($arr['_notapt']);
                $obj->setATime($arr['_a_time']);
                $all_answers[$i]=$obj;
                $i++;
            }
            return $all_answers;
        }
        else {
            return false;
        }
    }
}
