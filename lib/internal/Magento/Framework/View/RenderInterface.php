<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\View;

/**
 * Interface RenderInterface
 */
interface RenderInterface
{
    /**
     * Render template
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function renderTemplate($template, array $data);

    /**
     * Render container
     *
     * @param string $content
     * @param array $containerInfo
     * @return string
     */
    public function renderContainer($content, array $containerInfo = []);
}
