<?php

namespace ADesigns\CalendarBundle\Controller;

use ADesigns\CalendarBundle\Entity\EventEntity;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     *
     * @param  Request  $request
     * @return Response
     */
    public function loadCalendarAction(Request $request)
    {
        $startDatetime = \DateTime::createFromFormat('Y-m-d', $request->get('start'));
        $endDatetime   = \DateTime::createFromFormat('Y-m-d', $request->get('end'));

        $events = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime, $request))->getEvents();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_events = array();

        /** @var EventEntity $event */
        foreach ($events as $event) {
            $return_events[] = $event->toArray();
        }

        $response->setContent(json_encode($return_events));

        return $response;
    }
}
