<?php

//----------------------------------------------------------------------
//
//  Copyright (C) 2017 Artem Rodygin
//
//  This file is part of DataTables Symfony bundle.
//
//  You should have received a copy of the MIT License along with
//  the bundle. If not, see <http://opensource.org/licenses/MIT>.
//
//----------------------------------------------------------------------

namespace DataTables\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class DataTablesExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadServices()
    {
        $container = new ContainerBuilder();

        self::assertFalse($container->has('datatables'));

        $extension = new DataTablesExtension();
        $extension->load([], $container);
        $extension->process($container);

        self::assertTrue($container->has('datatables'));
    }

//    public function testLoadParameters()
//    {
//        $expected = [
//            'pupitre.landing' => [],
//            'pupitre.login'   => [],
//            'pupitre.npm'     => [],
//        ];
//
//        $container = new ContainerBuilder();
//
//        foreach ($expected as $parameter => $value) {
//            self::assertFalse($container->hasParameter($parameter));
//        }
//
//        $extension = new DataTablesExtension();
//        $extension->load([], $container);
//
//        foreach ($expected as $parameter => $value) {
//            self::assertTrue($container->hasParameter($parameter));
//            self::assertEquals($value, $container->getParameter($parameter));
//        }
//    }
//
//    public function testMailer()
//    {
//        $container = new ContainerBuilder();
//
//        self::assertFalse($container->has('pupitre.mailer'));
//
//        $extension = new DataTablesExtension();
//        $extension->load([], $container);
//        self::assertFalse($container->has('pupitre.mailer'));
//
//        $container->setParameter('mailer_sendfrom', null);
//        $extension->load([], $container);
//        self::assertTrue($container->has('pupitre.mailer'));
//    }
//
//    public function testListenersEmpty()
//    {
//        $config = [];
//
//        $container = new ContainerBuilder();
//
//        self::assertFalse($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertFalse($container->has('pupitre.event_listener.unhandled_exception'));
//
//        $extension = new DataTablesExtension();
//        $extension->load(['pupitre' => $config], $container);
//
//        self::assertFalse($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertFalse($container->has('pupitre.event_listener.unhandled_exception'));
//    }
//
//    public function testListenersFalse()
//    {
//        $config = [
//            'unauthorized_request' => false,
//            'unhandled_exception'  => false,
//        ];
//
//        $container = new ContainerBuilder();
//
//        self::assertFalse($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertFalse($container->has('pupitre.event_listener.unhandled_exception'));
//
//        $extension = new DataTablesExtension();
//        $extension->load(['pupitre' => $config], $container);
//
//        self::assertFalse($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertFalse($container->has('pupitre.event_listener.unhandled_exception'));
//    }
//
//    public function testListenersTrue()
//    {
//        $config = [
//            'unauthorized_request' => true,
//            'unhandled_exception'  => true,
//        ];
//
//        $container = new ContainerBuilder();
//
//        self::assertFalse($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertFalse($container->has('pupitre.event_listener.unhandled_exception'));
//
//        $extension = new DataTablesExtension();
//        $extension->load(['pupitre' => $config], $container);
//
//        self::assertTrue($container->has('pupitre.event_listener.unauthorized_request'));
//        self::assertTrue($container->has('pupitre.event_listener.unhandled_exception'));
//    }
}
