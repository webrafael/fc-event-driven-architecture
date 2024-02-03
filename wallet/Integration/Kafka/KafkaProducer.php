<?php namespace Wallet\Integration\Kafka;

use RdKafka\Producer;

class KafkaProducer
{
    protected $producer;

    public function __construct()
    {
        $this->producer = new Producer();
        $this->producer->setLogLevel(LOG_DEBUG);
        $this->producer->addBrokers("kafka:9092");
    }

    public function produce($topicName, $message)
    {
        $topic = $this->producer->newTopic($topicName);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $this->producer->poll(0);
    }
}
