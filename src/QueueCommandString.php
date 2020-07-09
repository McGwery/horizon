<?php

namespace Laravel\Horizon;

class QueueCommandString
{
    /**
     * Get the additional option string for the worker command.
     *
     * @param  \Laravel\Horizon\SupervisorOptions  $options
     * @return string
     */
    public static function toWorkerOptionsString(SupervisorOptions $options)
    {
        return sprintf('--name=%s --supervisor=%s %s',
            $options->workersName,
            $options->name,
            static::toOptionsString($options)
        );
    }

    /**
     * Get the additional option string for the supervisor command.
     *
     * @param  \Laravel\Horizon\SupervisorOptions  $options
     * @return string
     */
    public static function toSupervisorOptionsString(SupervisorOptions $options)
    {
        return sprintf('--workers-name=%s --balance=%s --max-processes=%s --min-processes=%s --nice=%s %s',
            $options->workersName,
            $options->balance,
            $options->maxProcesses,
            $options->minProcesses,
            $options->nice,
            static::toOptionsString($options)
        );
    }

    /**
     * Get the additional option string for the command.
     *
     * @param  \Laravel\Horizon\SupervisorOptions  $options
     * @param  bool  $paused
     * @return string
     */
    public static function toOptionsString(SupervisorOptions $options, $paused = false)
    {
        $string = sprintf('--backoff=%s --max-time=%s --max-jobs=%s --memory=%s --queue="%s" --sleep=%s --timeout=%s --tries=%s',
            $options->backoff, $options->maxTime, $options->maxJobs, $options->memory,
            $options->queue, $options->sleep, $options->timeout, $options->maxTries
        );

        if ($options->force) {
            $string .= ' --force';
        }

        if ($paused) {
            $string .= ' --paused';
        }

        return $string;
    }
}
