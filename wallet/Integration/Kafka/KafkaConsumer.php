<?php namespace Wallet\Integration\Kafka;

use RdKafka\Conf;
use RdKafka\Consumer;

class KafkaConsumer
{
    protected $groupId;
    protected $topicName;
    protected $consumer;

    public function __construct($groupId = "wallet", $topicName)
    {
        $this->groupId = $groupId;
        $this->topicName = $topicName;

        $conf = new Conf();
        $conf->set('group.id', $this->groupId);
        $conf->set('metadata.broker.list', "kafka:9092");

        $this->consumer = new Consumer($conf);
        $this->consumer->subscribe([$this->topicName]);
    }

    public function consume()
    {
        while (true) {
            $message = $this->consumer->consume(120 * 1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    echo sprintf("Message: %s\n", $message->payload);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo sprintf(
                        "No more messages; will wait for more\n"
                    );
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo sprintf("Timed out\n");
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
                    break;
            }
        }
    }
}
