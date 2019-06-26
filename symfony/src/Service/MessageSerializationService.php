<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;

class MessageSerializationService {
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    public function getDeserializedObject($data, $type) {
        return $this->serializer->deserialize($data, $type, 'json');
    }

    public function getSerializedObject($object) {
        return $this->serializer->serialize($object, 'json');
    }
}