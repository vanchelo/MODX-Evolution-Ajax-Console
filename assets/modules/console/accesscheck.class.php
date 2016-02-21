<?php

class AccessCheck
{
    /**
     * @var Console
     */
    protected $console;

    public function __construct(Console $console)
    {
        $this->console = $console;
    }

    /**
     * Check access rights
     *
     * @return bool
     */
    public function check()
    {
        $config = $this->console->config;

        if (!$config['check_ip']) {
            return true;
        }

        $filter = $config['filter'];
        $ips = $config[$filter];
        $ip = $this->getUserIp();

        if ($filter === 'whitelist' && in_array($ip, $ips)) {
            return true;
        } elseif ($filter === 'blacklist' && !in_array($ip, $ips)) {
            return true;
        }

        return false;
    }

    /**
     * Get the users ip address. Taken from the original snippet by garryn
     *
     * @return string The user ip address
     */
    protected function getUserIp()
    {
        // This returns the True IP of the client calling the requested page
        // Checks to see if HTTP_X_FORWARDED_FOR
        // has a value then the client is operating via a proxy
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] <> '') {
            $userIP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] <> '') {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'] <> '') {
            $userIP = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'] <> '') {
            $userIP = $_SERVER['HTTP_FORWARDED_FOR'];
        } else {
            $userIP = $_SERVER['REMOTE_ADDR'];
        }

        // return the IP we've figured out:
        return $userIP;
    }
}
