<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator;

class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Get all offices"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOfficesAction()
    {
        $offices = $this->getDoctrine()
            ->getRepository('AppBundle:Office')
            ->findAll();

        $view = $this->view($offices, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     description="Get An officy by id"
     * )
     *
     * @Route(requirements={"id" = "\d+"}, defaults={"id" = 1})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOfficeAction($id)
    {
        $office = $this->getDoctrine()
            ->getRepository('AppBundle:Office')
            ->find($id);

        $view = $this->view($office, 200);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     description="Retrieve offices nearby the given city"
     * )
     *
     * @QueryParam(name="city", description="City Name")
     * @QueryParam(name="lat", description="Location latitude")
     * @QueryParam(name="long", description="Location longitude")
     * @QueryParam(name="is_open_in_weekends", nullable=true, description="Is the office open in weekends")
     * @QueryParam(name="has_support_desk", nullable=true, description="Check if the office has a support desk")
     * @QueryParam(name="distance", requirements="\d+", default="25", nullable=true, description="distance in km")
     *
     * @param $city
     * @param $lat
     * @param $long
     *
     * @param $is_open_in_weekends
     * @param $has_support_desk
     * @param $distance
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getOfficesSearchAction($city, $lat, $long, $is_open_in_weekends, $has_support_desk, $distance)
    {
        if(!$city) {
            throw new HttpException(400, "There is no city provided!");
        }

        if(($lat || $long) && !($lat && $long)) {
            if (!$lat) {
                throw new HttpException(400, "A Longitude was provided, but there is no latitude to match it");
            }
            throw new HttpException(400, "A Latitude was provided, but there is no longitude to match it");
        }

        if(strtolower($has_support_desk) == 'false')
            $has_support_desk = null;

        if(strtolower($is_open_in_weekends) == 'false')
            $is_open_in_weekends = null;

        if(!($lat && $long)) {
            $offices = $this->getDoctrine()
                ->getRepository('AppBundle:Office')
                ->findByCity($city, $is_open_in_weekends, $has_support_desk);
        } else {
            $offices = $this->getDoctrine()
                ->getRepository('AppBundle:Office')
                ->findByLatAndLong($lat, $long, $is_open_in_weekends, $has_support_desk, $distance);

            $formatOffices = $this->get('app.formatOffices');
            $offices = $formatOffices->formatOffices($offices);
        }

        $view = $this->view($offices, 200);
        return $this->handleView($view);
    }
}
