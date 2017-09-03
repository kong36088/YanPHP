<?php
/*
 * YanPHP
 * User: weilongjiang(江炜隆)<william@jwlchina.cn>
 * Date: 2017/9/3
 * Time: 16:53
 */

namespace App\Cgi\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'uid';

    protected $keyType = 'int';

    public static function getById($id): Collection
    {
        return static::where($id)->get();
    }

    public static function getByCond($cond): Collection
    {
        return static::where($cond)->get();
    }

    public static function updateByCond($cond, $update): bool
    {
        return static::where($cond)->update($update);
    }

    public static function deleteById($id)
    {
        return static::where($id)->delete();
    }
}