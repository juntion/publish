<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TransTrait;

/**
 * 所有model类需要继承改类
 *
 * @author aron
 * @date 2019.11.8
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    use TransTrait;
    public static $language_id;

    public function __construct($attribute = [])
    {
        if (!defined('IS_ADMIN_FLAG')) {
            die('Illegal Access');
        }
        parent::__construct($attribute);
        self::$language_id = $_SESSION['languages_id'];
    }
}
