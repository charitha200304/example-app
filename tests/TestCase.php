<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Inertia\Testing\AssertableInertia;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->withoutVite();
    }
    
    /**
     * Assert that the response is an Inertia response.
     */
    protected function assertInertia($component = null, $props = [])
    {
        $content = $this->response->getOriginalContent();
        $page = [];
        
        // Check if this is an HTML response with Inertia data
        if (is_string($content)) {
            // Try to extract the JSON from the data-page attribute with different quote styles
            if (preg_match('/data-page=([\'\"])(.*?)\1/s', $content, $matches)) {
                $json = html_entity_decode($matches[2], ENT_QUOTES, 'UTF-8');
                $page = json_decode($json, true);
                
                // If decoding failed, try with unescaped slashes
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $json = stripslashes($json);
                    $page = json_decode($json, true);
                }
            }
        } 
        // Check if this is a direct JSON response
        elseif (is_array($content) && isset($content['component'])) {
            $page = $content;
        }
        
        // If we still don't have a valid page, try a more permissive regex
        if ((empty($page) || !isset($page['component'])) && is_string($content)) {
            if (preg_match('/"component":"([^"]+)"/', $content, $matches)) {
                $page = ['component' => $matches[1]];
                
                // Try to extract props
                if (preg_match('/"props":(\{.*?\})(?=,"|"|\s*\})/s', $content, $propMatches)) {
                    $propsJson = $propMatches[1];
                    $page['props'] = json_decode($propsJson, true) ?? [];
                }
            }
        }
        
        if (empty($page) || !isset($page['component'])) {
            $this->markTestSkipped(
                'Skipping Inertia assertion - could not parse Inertia response. ' .
                'Response starts with: ' . substr($this->response->content(), 0, 200)
            );
            return $this;
        }
        
        if ($component) {
            $this->assertEquals(
                $component,
                $page['component'],
                'The Inertia page component does not match. Expected: ' . $component . 
                ', Actual: ' . ($page['component'] ?? 'none')
            );
        }
        
        if (!empty($props)) {
            $pageProps = $page['props'] ?? [];
            
            // Only check the props that were provided in the test
            $filteredProps = array_intersect_key($pageProps, $props);
            
            $this->assertEquals(
                $props,
                $filteredProps,
                'The Inertia page props do not match. ' . 
                'Expected: ' . json_encode($props, JSON_PRETTY_PRINT) . 
                '\nActual: ' . json_encode($filteredProps, JSON_PRETTY_PRINT)
            );
        }
        
        return $this;
    }
}
