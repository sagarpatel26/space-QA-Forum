<?php
/**
 * sagarpatel
 * Date: 15-Mar-15
 * Time: 8:42 PM
 */

include_once('_database.php');

class _question
{
    private $_qid;
    private $_q_uid;
    private $_description;
    private $_curious;
    private $_q_time;

    private static $_all_question = array();
    private static $counter = 0;

    function __construct()
    {
        $this->_qid = null;
        $this->_q_uid = null;
        $this->_description = null;
        $this->_curious = null;
        $this->_q_time = 0;
    }

    /**
     * @return null
     */
    public function getCurious()
    {
        return $this->_curious;
    }

    /**
     * @param null $curious
     */
    public function setCurious($curious)
    {
        $this->_curious = $curious;
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
    public function getQTime()
    {
        return $this->_q_time;
    }

    /**
     * @param null $q_time
     */
    public function setQTime($q_time)
    {
        $this->_q_time = $q_time;
    }

    /**
     * @return null
     */
    public function getQUid()
    {
        return $this->_q_uid;
    }

    /**
     * @param null $q_uid
     */
    public function setQUid($q_uid)
    {
        $this->_q_uid = $q_uid;
    }

    /**
     * @return null
     */
    public function getQid()
    {
        return $this->_qid;
    }

    /**
     * @param null $qid
     */
    public function setQid($qid)
    {
        $this->_qid = $qid;
    }

    /**
     * @return int
     */
    public static function getCounter()
    {
        return self::$counter;
    }

    /**
     * @param int $counter
     */
    public static function setCounter($counter)
    {
        self::$counter = $counter;
    }



    function _get_fdb_qid($_ref_qid)
    {
        $connection = _database::get_connection();
        $query = "SELECT * FROM `_questions` WHERE `_qid`=$_ref_qid";

        $result = $connection->query($query);

        if ($result->num_rows>0)
        {
            $result_array = $result->fetch_assoc();
            $this->_qid = $result_array['_qid'];
            $this->_q_uid = $result_array['_q_uid'];
            $this->_description = $result_array['_description'];
            $this->_curious = $result_array['_curious'];
            $this->_q_time = $result_array['_q_time'];

            return true;
        }
        else {
            return false;
        }
    }

    function _set_data($_q_uid,$_description)
    {
        $this->_q_uid = $_q_uid;
        $this->_description = $_description;
        $this->_curious = 0;
        $this->_q_time = null;
    }

    function _insert_db()
    {
        $connection = _database::get_connection();
        $this->_q_time = date('d-m-Y');
        $this->_curious=0;
        $query = "INSERT INTO `_questions`(`_q_uid`, `_description`, `_curious`, `_q_time`) VALUES ($this->_q_uid,'$this->_description',$this->_curious,now())";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return $connection->error;
    }

    static function _chng_curious($_ref_qid,$chnguid)
    {
        $connection = _database::get_connection();
        $q = new _question();
        if(!$q->_get_fdb_qid($_ref_qid))
        {
            return null;
        }
        $checkq = "SELECT `_curious` FROM `_qiduid` WHERE `_uid` = $chnguid AND `_qid` = $q->_qid";
        $res=$connection->query($checkq);
        if ($res->num_rows>0)
        {
            $arr = $res->fetch_array();
            if ($arr['_curious']==1)
            {
                $updq = "UPDATE `_qiduid` SET `_curious`= 0 WHERE `_uid` = $chnguid AND `_qid` = $q->_qid";
                if ($connection->query($updq))
                {
                    $q->_dcr_curious();
                    return $q;
                }
                else
                    return null;
            }
            else
            {
                $updq = "UPDATE `_qiduid` SET `_curious`= 1 WHERE `_uid` = $chnguid AND `_qid` = $q->_qid";
                if ($connection->query($updq))
                {
                    $q->_incr_curious();
                    return $q;
                }
                else
                    return null;
            }
        }
        else
        {
            $instq = "INSERT INTO `_qiduid`(`_uid`, `_qid`, `_curious`) VALUES ($chnguid,$q->_qid,1);";
            if ($connection->query($instq))
            {
                $q->_incr_curious();
                return $q;
            }
            else
                return null;
        }

    }
    function _incr_curious()
    {
        $connection = _database::get_connection();
        $this->_curious++;
        $query = "UPDATE `spacev0.0`.`_questions` SET `_curious` = $this->_curious WHERE `_questions`.`_qid` = $this->_qid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    function _dcr_curious()
    {
        $connection = _database::get_connection();
        $this->_curious--;
        $query = "UPDATE `spacev0.0`.`_questions` SET `_curious` = $this->_curious WHERE `_questions`.`_qid` = $this->_qid;";
        if ($connection->query($query)==true)
        {
            return true;
        }
        return false;
    }

    static function _get_all_question_by_date()
    {
        if (self::$counter==0)
        {
            $connection = _database::get_connection();
            $query = "SELECT * FROM `_questions` ORDER BY `_q_time` DESC";
            ;
            if (!($res = $connection->query($query)))
            {
                return false;
            }
            else
            {
                $i=0;
                while ($arr = $res->fetch_array())
                {
                    $obj = new _question();
                    $obj->setQid($arr['_qid']);
                    $obj->setQUid($arr['_q_uid']);
                    $obj->setDescription($arr['_description']);
                    $obj->setCurious($arr['_curious']);
                    $obj->setQTime($arr['_q_time']);
                    self::$_all_question[$i]=$obj;
                    $i++;
                }
            }
            return self::$_all_question;
        }
        else
        {
            if ((self::$counter++)==10)
            {
                self::$counter=0;
            }
            return self::$_all_question;
        }
    }

    function __toString()
    {
        $str = 'Qid ' . $this->_qid . ' Description ' . $this->_description;
        return $str;
    }
} 