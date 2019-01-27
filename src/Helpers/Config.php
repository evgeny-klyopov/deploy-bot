<?php
/**
 * User: ス
 * Date: 27.01.2019
 * Time: 22:48
 */

namespace Alva\DeployBot\Helpers;

class Config
{
    public $bot_api_key;
    public $bot_username;
    public $proxy;
    public $hook_url;
    public $allowed_chat_id;
    public $project;

    private $required = [
        'bot_api_key',
        'bot_username',
        'bot_username',
        'project',
        'allowed_chat_id',
    ];

    /**
     * @param string $hookUrl
     * @param array  $setting
     *
     * @return Config
     * @throws \Exception
     */
    public static function get(string $hookUrl, array $setting): self
    {
        $config = new self();

        foreach ($setting as $field => $value) {
            $config->$field = $value;
        }

        $config->hook_url = $hookUrl
            . (false !== \strpos($hookUrl, '?') ? '&' : '?')
            . 'project=' . $config->project;

        return $config->check();
    }

    /**
     * @return Config
     * @throws \Exception
     */
    private function check(): self
    {
        $errorField = [];
        foreach ($this->required as $field) {
            if (empty($this->$field)) {
                $errorField[] = $field;
            }
        }

        if (!empty($errorField)) {
            throw new \Exception('Not set field(s) - ' . implode(', ', $errorField));
        }

        return $this;
    }
}