<?php
/**
 * User: ス
 * Date: 27.01.2019
 * Time: 22:40
 */

namespace Alva\DeployBot;

use Alva\DeployBot\Helpers\Config;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class App
{
    private $projects = [];

    /**
     * App constructor.
     *
     * @param $setting
     *
     * @throws \Exception
     */
    public function __construct(array $setting)
    {
        if (empty($setting['hook_url'])) {
            throw new \Exception('Not found hook_url');
        }

        if (empty($setting['projects'])) {
            throw new \Exception('Not found setting project');
        }

        foreach ($setting['projects'] as $config) {
            $this->projects[] = Config::get($setting['hook_url'], $config);
        }
    }

    /**
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function setWebHook()
    {
        /** @var Config $config */
        foreach ($this->projects as $config) {
            $telegram = new Telegram($config->bot_api_key, $config->bot_username);

            if (!empty($config->proxy)) {
                Request::setClient(new \GuzzleHttp\Client([
                    'base_uri' => 'https://api.telegram.org',
                    'proxy' => $config->proxy,
                ]));
            }

            // Set webhook
            $result = $telegram->setWebhook($config->hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        }
    }
}