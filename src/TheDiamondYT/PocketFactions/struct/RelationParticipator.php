<?php

namespace TheDiamondYT\PocketFactions\struct;

interface RelationParticipator {
    public function describeTo(RelationParticipator $that);
    
    public function getColorTo(RelationParticipator $that);
}
