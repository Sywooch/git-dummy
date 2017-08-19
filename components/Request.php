<?php
    /**
     * @link http://www.yiiframework.com/
     * @copyright Copyright (c) 2008 Yii Software LLC
     * @license http://www.yiiframework.com/license/
     */

    namespace app\components;

    use Yii;
    use yii\base\InvalidConfigException;
    use yii\helpers\StringHelper;



    class Request extends \yii\web\Request
    {
        /**
         * The name of the HTTP header for sending CSRF token.
         */
        const CSRF_HEADER = 'X-CSRF-Token';
        /**
         * The length of the CSRF token mask.
         */
        const CSRF_MASK_LENGTH = 8;


        public $enableCsrfValidation = true;
        /**
         * @var string the name of the token used to prevent CSRF. Defaults to '_csrf'.
         * This property is used only when [[enableCsrfValidation]] is true.
         */
        public $csrfParam = '_csrf';
        /**
         * @var array the configuration for creating the CSRF [[Cookie|cookie]]. This property is used only when
         * both [[enableCsrfValidation]] and [[enableCsrfCookie]] are true.
         */
        public $csrfCookie = ['httpOnly' => true];
        /**
         * @var boolean whether to use cookie to persist CSRF token. If false, CSRF token will be stored
         * in session under the name of [[csrfParam]]. Note that while storing CSRF tokens in session increases
         * security, it requires starting a session for every page, which will degrade your site performance.
         */
        public $enableCsrfCookie = true;
        /**
         * @var boolean whether cookies should be validated to ensure they are not tampered. Defaults to true.
         */
        public $enableCookieValidation = true;
        /**
         * @var string a secret key used for cookie validation. This property must be set if [[enableCookieValidation]] is true.
         */
        public $cookieValidationKey;
        /**
         * @var string the name of the POST parameter that is used to indicate if a request is a PUT, PATCH or DELETE
         * request tunneled through POST. Defaults to '_method'.
         * @see getMethod()
         * @see getBodyParams()
         */
        public $methodParam = '_method';
        /**
         * @var array the parsers for converting the raw HTTP request body into [[bodyParams]].
         * The array keys are the request `Content-Types`, and the array values are the
         * corresponding configurations for [[Yii::createObject|creating the parser objects]].
         * A parser must implement the [[RequestParserInterface]].
         *
         * To enable parsing for JSON requests you can use the [[JsonParser]] class like in the following example:
         *
         * ```
         * [
         *     'application/json' => 'yii\web\JsonParser',
         * ]
         * ```
         *
         * To register a parser for parsing all request types you can use `'*'` as the array key.
         * This one will be used as a fallback in case no other types match.
         *
         * @see getBodyParams()
         */
        public $parsers = [];

        /**
         * @var CookieCollection Collection of request cookies.
         */
        private $_cookies;
        /**
         * @var HeaderCollection Collection of request headers.
         */
        private $_headers;


        public function getQueryParam($name, $defaultValue = null)
        {
            $params = $this->getQueryParams();

            if(method_exists($this, $name)){
                $params[$name]=$this->{$name}($params[$name] );
            }
            return isset($params[$name]) ? $params[$name] : $defaultValue;
        }

        public function getBodyParam($name, $defaultValue = null)
        {
            $params = $this->getBodyParams();

            if(method_exists($this, $name)){
                $params[$name]=$this->{$name}($params[$name] );
            }
            return isset($params[$name]) ? $params[$name] : $defaultValue;
        }

        protected function dateto($val){
            return ($this->validateDate($val))?$val:'';
        }
        protected function datefrom($val){
            return ($this->validateDate($val))?$val:'';
        }
        protected function key($val){
           return $this->validateString($val);
        }
        protected function id($val){
            return (int)$val;
        }
        protected function amount($val){
            return (float)$val;
        }
        protected function product($val){
            return (int)$val;
        }
        protected function step($val){
            return ($this->validateStep($val))?$val:'';
        }

        //code for approve email
        protected function code($val){
            return ($this->validateString($val))?$val:'';
        }

        protected function bitid($val){
            return (int)$val;
        }

        protected function msg($val){
            return $this->validateString($val);
        }

        protected function validateStep($val){
            $pattern  = '/([0-9]+)/';
            return (preg_match($pattern, $val, $matches))?true:false;
        }

        protected function validateDate($val){
            $pattern  = '/^([0-9\-\:\ \.\/]+)$/';
            preg_match($pattern, $val, $matches);
            return ($matches)?true:false;
        }

        protected function validateString($val){
            $m=['"',"'",':',';','%','#','$','^','&','!',','];
            return str_replace($m,'',$val);
        }

        public function QueryParamToString($name=null)
        {
            $params = $this->getQueryParams();

            if(!is_array($name)){
                if($name){
                    unset($params[$name]);
                }
            }else{
                foreach($name as $m){
                    unset($params[$m]);
                }
            }
            return http_build_query($params);
        }
    }
