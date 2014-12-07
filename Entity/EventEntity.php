<?php

namespace ADesigns\CalendarBundle\Entity;

/**
 * Class for holding a calendar event's details.
 *
 * @author Mike Yudin <mikeyudin@gmail.com>
 */
class EventEntity
{
    /**
     * @var mixed Unique identifier of this event (optional).
     */
    protected $id;

    /**
     * @var string Title/label of the calendar event.
     */
    protected $title;

    /**
     * @var string URL Relative to current path.
     */
    protected $url;

    /**
     * @var string HTML color code for the bg color of the event label.
     */
    protected $bgColor;

    /**
     * @var string HTML color code for the foregorund color of the event label.
     */
    protected $fgColor;

    /**
     * @var string css class for the event label
     */
    protected $cssClass;

    /**
     * @var \DateTime DateTime object of the event start date/time.
     */
    protected $startDatetime;

    /**
     * @var \DateTime DateTime object of the event end date/time.
     */
    protected $endDatetime;

    /**
     * @var boolean Is this an all day event?
     */
    protected $allDay = false;

    /**
     * @var array Non-standard fields
     */
    protected $otherFields = array();

    /**
     * @param string    $title
     * @param \DateTime $startDatetime
     * @param \DateTime $endDatetime
     * @param bool      $allDay
     */
    public function __construct($title, \DateTime $startDatetime, \DateTime $endDatetime = null, $allDay = false)
    {
        $this->title = $title;
        $this->startDatetime = $startDatetime;
        $this->setAllDay($allDay);

        if ($endDatetime === null && $this->allDay === false) {
            throw new \InvalidArgumentException("Must specify an event End DateTime if not an all day event.");
        }

        $this->endDatetime = $endDatetime;
    }

    /**
     * Convert calendar event details to an array
     *
     * @return array $event
     */
    public function toArray()
    {
        $event = array();

        if ($this->id !== null) {
            $event['id'] = $this->id;
        }

        $event['title'] = $this->title;
        $event['start'] = $this->startDatetime->format("Y-m-d\TH:i:sP");

        if ($this->url !== null) {
            $event['url'] = $this->url;
        }

        if ($this->bgColor !== null) {
            $event['backgroundColor'] = $this->bgColor;
            $event['borderColor'] = $this->bgColor;
        }

        if ($this->fgColor !== null) {
            $event['textColor'] = $this->fgColor;
        }

        if ($this->cssClass !== null) {
            $event['className'] = $this->cssClass;
        }

        if ($this->endDatetime !== null) {
            $event['end'] = $this->endDatetime->format("Y-m-d\TH:i:sP");
        }

        $event['allDay'] = $this->allDay;

        foreach ($this->otherFields as $field => $value) {
            $event[$field] = $value;
        }

        return $event;
    }

    /**
     * @param mixed $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setBgColor($color)
    {
        $this->bgColor = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getBgColor()
    {
        return $this->bgColor;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setFgColor($color)
    {
        $this->fgColor = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgColor()
    {
        return $this->fgColor;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setCssClass($class)
    {
        $this->cssClass = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param \DateTime $start
     *
     * @return $this
     */
    public function setStartDatetime(\DateTime $start)
    {
        $this->startDatetime = $start;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * @param \DateTime $end
     *
     * @return $this
     */
    public function setEndDatetime(\DateTime $end)
    {
        $this->endDatetime = $end;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * @param bool $allDay
     *
     * @return $this
     */
    public function setAllDay($allDay = false)
    {
        $this->allDay = (boolean) $allDay;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function addField($name, $value)
    {
        $this->otherFields[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeField($name)
    {
        if (array_key_exists($name, $this->otherFields)) {
            unset($this->otherFields[$name]);
        }

        return $this;
    }
}
