<?php declare(strict_types=1);
/**
 * Interface for template renderers
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://pieterhordijk.com>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Template;

/**
 * Interface for template renderers
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Renderer
{
    /**
     * Renders a template
     *
     * @param string $template The template to render
     * @param array  $data     The template variables
     *
     * @return string The rendered template
     */
    public function render(string $template, array $data = []): string;
}
