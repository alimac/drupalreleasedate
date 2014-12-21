<?php
namespace DrupalReleaseDate\Sampling;

class SampleSet implements SampleSetInterface
{
    protected $samples = array();
    protected $length = 0;

    public function length()
    {
        return $this->length;
    }

    public function insert(Sample $sample)
    {
        if ($this->length) {
            $sample->setDiff($this->samples[$this->length - 1]);
        }

        $this->samples[] = $sample;

        $this->length++;
    }

    public function get($index)
    {
        return $this->samples[$index];
    }

    public function getLast()
    {
        return $this->get($this->length() - 1);
    }
}
