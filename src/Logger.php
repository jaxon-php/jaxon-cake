<?php

namespace Jaxon\Cake;

use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

use Cake\Log\Log as CakeLogger;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function log($sLevel, $sMessage, array $aContext = [])
    {
        $sMessage = rtrim((string)$sMessage, ' .') . '. ' . print_r($aContext, true);

        // Map the PSR-3 severity to CodeIgniter log level.
        switch($sLevel)
        {
            case LogLevel::EMERGENCY:
                CakeLogger::write('emergency', $sMessage);
                break;
            case LogLevel::ALERT:
                CakeLogger::write('alert', $sMessage);
                break;
            case LogLevel::CRITICAL:
                CakeLogger::write('critical', $sMessage);
                break;
            case LogLevel::ERROR:
                CakeLogger::write('error', $sMessage);
                break;
            case LogLevel::WARNING:
                CakeLogger::write('warning', $sMessage);
                break;
            case LogLevel::DEBUG:
                CakeLogger::write('debug', $sMessage);
                break;
            case LogLevel::NOTICE:
                CakeLogger::write('notice', $sMessage);
                break;
            case LogLevel::INFO:
                CakeLogger::write('info', $sMessage);
                break;
            default:
                throw new InvalidArgumentException("Unknown severity level");
        }
    }
}
