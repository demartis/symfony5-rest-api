<?php
/**
 *
 * This file is part of a repository on GitHub.
 *
 * (c) Riccardo De Martis <riccardo@demartis.it>
 *
 * <https://github.com/demartis>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace App\Utils\Jttp;

use App\Utils\Jttp\Exception\InternalJttpException;
use App\Utils\Jttp\Exception\MalformedJttpException;

class Jttp
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR   = 'error';

    public const FIELD_STATUS  = 'status';
    public const FIELD_CODE    = 'code';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_DATA    = 'data';
    public const FIELD_ERROR   = 'error';

    /** @var string success|error */
    protected $status;

    /** @var int HTTP Status code */
    protected $code;

    /** @var string|null HTTP Status text */
    protected $message;

    /** @var array|null success response content */
    protected $data;

    /** @var array|null optional error response content */
    protected $error;

    /**
     * JttpResponse constructor.
     * @param string $status
     * @param int $code
     * @param string|null $message
     * @param array|null $data
     * @param array|null $error
     *
     * @throws MalformedJttpException
     */
    public function __construct(string $status, int $code, ?string $message, ?array $data=null, ?array $error=null)
    {
        if(!$this->isValidStatus($status)) {
            throw new MalformedJttpException('Status does not conform to Jttp spec.');
        }

        if($status==static::STATUS_SUCCESS && !is_null($error)) {
            throw new MalformedJttpException('Field "error" must be set only in "error" statuses.');
        }

        if($status==static::STATUS_ERROR && !is_null($data)) {
            throw new MalformedJttpException('Field "data" must be set only in "success" statuses.');
        }

        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
    }

    public function toArray(): array
    {
        $res=[];

        $res[self::FIELD_STATUS]=$this->status;
        $res[self::FIELD_CODE]=$this->code;
        $res[self::FIELD_MESSAGE]=$this->message;

        switch ($this->status){
            case self::STATUS_SUCCESS:
                $res[self::FIELD_DATA]=$this->data;
                break;
            case self::STATUS_ERROR:
                $res[self::FIELD_ERROR]=$this->error;
                break;
            default:
                throw new InternalJttpException('Unknown status code');
                break;
        }

        return $res;
    }

    public function toJson(): string
    {;
        return json_encode($this->toArray());
    }

    public static function success(array $data = null): Jttp
    {
        return new static(
            static::STATUS_SUCCESS,
            HttpUtils::getStatusCode200(),
            HttpUtils::getHttpStatus(HttpUtils::getStatusCode200()),
            $data);
    }

    public static function error(int $statusCode, ?string $statusCodeMessage=null, array $error = null): Jttp
    {
        return new static(
            static::STATUS_ERROR,
            $statusCode,
            $statusCodeMessage==null? HttpUtils::getHttpStatus($statusCode) : $statusCodeMessage,
            null,
            $error);
    }


    protected function isValidStatus(string $status): bool
    {
        $validStatuses = array(static::STATUS_SUCCESS, static::STATUS_ERROR);
        return \in_array($status, $validStatuses, true);
    }

    function isValidJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}