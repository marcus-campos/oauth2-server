<?php

/*
 * This file is part of OAuth 2.0 Laravel.
 *
 * (c) Marcus Campos <marcus_vinícius_campos@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarcusCampos\OAuth2Server\Middleware;

use Closure;
use League\OAuth2\Server\Exception\AccessDeniedException;
use MarcusCampos\OAuth2Server\Authorizer;

/**
 * This is the oauth user middleware class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class OAuthUserOwnerMiddleware
{
    /**
     * The Authorizer instance.
     *
     * @var \LucaDegasperi\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * Create a new oauth user middleware instance.
     *
     * @param \LucaDegasperi\OAuth2Server\Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @throws \League\OAuth2\Server\Exception\AccessDeniedException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->authorizer->setRequest($request);

        if ($this->authorizer->getResourceOwnerType() !== 'user') {
            throw new AccessDeniedException();
        }

        return $next($request);
    }
}