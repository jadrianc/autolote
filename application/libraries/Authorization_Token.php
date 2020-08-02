<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
*   Authorization_Token
* -------------------------------------------------------------------
* API Token Check and Generate
*
* @author: Jeevan Lal
* @version: 0.0.5
*/

require_once APPPATH . 'third_party/php-jwt/JWT.php';
require_once APPPATH . 'third_party/php-jwt/BeforeValidException.php';
require_once APPPATH . 'third_party/php-jwt/ExpiredException.php';
require_once APPPATH . 'third_party/php-jwt/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class Authorization_Token
{
    /**
     * Token Key
     */
    protected $token_key;

    /**
     * Token algorithm
     */
    protected $token_algorithm;

    /**
     * Request Header Name
     */
    protected $token_header = ['authorization','Authorization'];

    /**
     * Token Expire Time
     * ----------------------
     * ( 1 Day ) : 60 * 60 * 24 = 86400
     * ( 1 Hour ) : 60 * 60     = 3600
     */
    protected $token_expire_time;


    public function __construct()
    {
        $this->CI =& get_instance();

        /**
         * jwt config file load
         */
        $this->CI->load->config('jwt');

        /**
         * Load Config Items Values
         */
        $this->token_key        = $this->CI->config->item('jwt_key');
        $this->token_algorithm  = $this->CI->config->item('jwt_algorithm');
        $this->token_expire_time  = $this->CI->config->item('jwt_expire_time');
    }

    /**
     * Generate Token
     * @param: user data
     */
    public function generateToken($data)
    {
        try {
            return JWT::encode($data, $this->token_key, $this->token_algorithm);
        } catch (Exception $e) {
            return 'Message: ' .$e->getMessage();
        }
    }

    public function generateTokenReset($data)
    {
        try 
        {

            $this->token_expire_time  = "120";
            return JWT::encode($data, $this->token_key, $this->token_algorithm);
        } catch (Exception $e) {
            return 'Message: ' .$e->getMessage();
        }
    }

    /**
     * Validate Token with Header
     * @return : user informations
     */
    public function validateToken()
    {
        /**
         * Request All Headers
         */
        $headers = $this->CI->input->request_headers();
        
        /**
         * Authorization Header Exists
         */
        $token_data = $this->tokenIsExist($headers);
        if ($token_data['status'] === true) {
            try {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($headers[$token_data['key']], $this->token_key, array($this->token_algorithm));
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $e->getMessage()];
                }

                if (!empty($token_decode) and is_object($token_decode)) {
                    // Check User ID (exists and numeric)
                    if (empty($token_decode->id) or !is_numeric($token_decode->id)) {
                        return ['status' => false, 'message' => 'User ID Not Define!'];

                    // Check Token Time
                    } elseif (empty($token_decode->time or !is_numeric($token_decode->time))) {
                        return ['status' => false, 'message' => 'Token Time Not Define!'];
                    } else {
                        /**
                         * Check Token Time Valid
                         */
                        $time_difference = strtotime('now') - $token_decode->time;
                        if ($time_difference >= $this->token_expire_time) {
                            return ['status' => false, 'message' => 'Token Time Expire.'];
                        } else {
                            /**
                             * All Validation False Return Data
                             */
                            return ['status' => true, 'data' => $token_decode];
                        }
                    }
                } else {
                    return ['status' => false, 'message' => 'Forbidden'];
                }
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        } else {
            // Authorization Header Not Found!
            return ['status' => false, 'message' => $token_data['message'] ];
        }
    }

    /**
     * Validate Token with POST Request
     */
    public function validateTokenPost()
    {
        if (isset($_POST['token'])) {
            $token = $this->CI->input->post('token', true);
            if (!empty($token) and is_string($token) and !is_array($token)) {
                try {
                    /**
                     * Token Decode
                     */
                    try {
                        $token_decode = JWT::decode($token, $this->token_key, array($this->token_algorithm));
                    } catch (Exception $e) {
                        return ['status' => false, 'message' => $e->getMessage()];
                    }
    
                    if (!empty($token_decode) and is_object($token_decode)) {
                        // Check User ID (exists and numeric)
                        if (empty($token_decode->id) or !is_numeric($token_decode->id)) {
                            return ['status' => false, 'message' => 'User ID Not Define!'];
    
                        // Check Token Time
                        } elseif (empty($token_decode->time or !is_numeric($token_decode->time))) {
                            return ['status' => false, 'message' => 'Token Time Not Define!'];
                        } else {
                            /**
                             * Check Token Time Valid
                             */
                            $time_difference = strtotime('now') - $token_decode->time;
                            if ($time_difference >= $this->token_expire_time) {
                                return ['status' => false, 'message' => 'Token Time Expire.'];
                            } else {
                                /**
                                 * All Validation False Return Data
                                 */
                                return ['status' => true, 'data' => $token_decode];
                            }
                        }
                    } else {
                        return ['status' => false, 'message' => 'Forbidden'];
                    }
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $e->getMessage()];
                }
            } else {
                return ['status' => false, 'message' => 'Token is not defined.' ];
            }
        } else {
            return ['status' => false, 'message' => 'Token is not defined.'];
        }
    }

    /**
     * Validate Token Override in Funtion
     * @param: token
     */
    public function validateTokenOverride($token)
    {
        if (!empty($token) and is_string($token) and !is_array($token)) {
            try {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($token, $this->token_key, array($this->token_algorithm));
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $e->getMessage()];
                }
    
                if (!empty($token_decode) and is_object($token_decode)) {
                    // Check User ID (exists and numeric)
                    if (empty($token_decode->id) or !is_numeric($token_decode->id)) {
                        return ['status' => false, 'message' => 'User ID Not Define!'];
    
                    // Check Token Time
                    } elseif (empty($token_decode->time or !is_numeric($token_decode->time))) {
                        return ['status' => false, 'message' => 'Token Time Not Define!'];
                    } else {
                        /**
                         * Check Token Time Valid
                         */
                        $time_difference = strtotime('now') - $token_decode->time;
                        if ($time_difference >= $this->token_expire_time) {
                            return ['status' => false, 'message' => 'Token Time Expire.'];
                        } else {
                            /**
                             * All Validation False Return Data
                             */
                            return ['status' => true, 'data' => $token_decode];
                        }
                    }
                } else {
                    return ['status' => false, 'message' => 'Forbidden'];
                }
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => 'Token is not defined.' ];
        }
    }

    /**
     * Token Header Check
     * @param: request headers
     */
    public function tokenIsExist($headers)
    {
        if (!empty($headers) and is_array($headers)) {
            foreach ($this->token_header as $key) {
                if (array_key_exists($key, $headers) and !empty($key)) {
                    return ['status' => true, 'key' => $key];
                }
            }
        }
        return ['status' => false, 'message' => 'Token is not defined.'];
    }


    /**
     * Refresh Token
     * @param: token
     */
    public function refreshToken($token)
    {
        if (!empty($token) and is_string($token) and !is_array($token)) {
            try {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($token, $this->token_key, array($this->token_algorithm));
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $e->getMessage()];
                }
    
                if (!empty($token_decode) and is_object($token_decode)) {
                    // Check User ID (exists and numeric)
                    if (empty($token_decode->id) or !is_numeric($token_decode->id)) {
                        return ['status' => false, 'message' => 'User ID Not Define!'];
    
                    // Check Token Time
                    } elseif (empty($token_decode->time or !is_numeric($token_decode->time))) {
                        return ['status' => false, 'message' => 'Token Time Not Define!'];
                    } else {
                        /**
                         * Check Token Time Valid
                         */
                        $time_difference = strtotime('now') - $token_decode->time;
                        if ($time_difference >= $this->token_expire_time) {
                            $token_decode->time = time();
                            return JWT::encode($token_decode, $this->token_key, $this->token_algorithm);
                        } else {
                            /**
                             * All Validation False Return Data
                             */
                            return JWT::encode($token_decode, $this->token_key, $this->token_algorithm);
                        }
                    }
                } else {
                    return ['status' => false, 'message' => 'Forbidden'];
                }
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ['status' => false, 'message' => 'Token is not defined.' ];
        }
    }


    /**
     * Fetch User Data
     * -----------------
     * @param: token
     * @return: user_data
     */
    public function userData()
    {
        /**
         * Request All Headers
         */
        $headers = $this->CI->input->request_headers();

        /**
         * Authorization Header Exists
         */
        $token_data = $this->tokenIsExist($headers);
        if ($token_data['status'] === true) {
            try {
                /**
                 * Token Decode
                 */
                try {
                    $token_decode = JWT::decode($headers[$token_data['key']], $this->token_key, array($this->token_algorithm));
                } catch (Exception $e) {
                    return ['status' => false, 'message' => $e->getMessage()];
                }

                if (!empty($token_decode) and is_object($token_decode)) {
                    return $token_decode;
                } else {
                    return ['status' => false, 'message' => 'Forbidden'];
                }
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        } else {
            // Authorization Header Not Found!
            return ['status' => false, 'message' => $token_data['message'] ];
        }
    }
}
