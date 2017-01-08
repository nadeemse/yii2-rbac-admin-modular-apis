<?php
/**
 * Trait that contains needed behaviors for protect controller by OAuth2
 */

namespace api\core\components\traits\controllers;

use core\components\api\exception\UnsupportedOperationException;
use Yii;

trait SearchTrait
{
    /**
     * If query string contains 'q' parameter.
     * This indicates the request is searching an entity
     *
     * @var boolean
     */
    protected $isSearch = false;
    /**
     * If query contains 'fields' parameter.
     * This indicates the request wants back only certain fields from a record
     *
     * @var boolean
     */
    protected $isPartial = false;
    /**
     * Set when there is a 'limit' query parameter
     *
     * @var integer
     */
    protected $limit = null;
    /**
     * Set when there is an 'offset' query parameter
     *
     * @var integer
     */
    protected $offset = null;
    /**
     * Array of fields requested to be searched against
     *
     * @var array
     */
    protected $searchFields = null;
    /**
     * Array of fields requested to be returned
     *
     * @var array
     */
    protected $partialFields = null;
    /**
     * Sets which fields may be searched against, and which fields are allowed to be returned in
     * partial responses.  This will be overridden in child Controllers that support searching
     * and partial responses.
     *
     * @var array
     */
    protected $allowedFields = [
        'search'   => [],
        'partials' => [],
    ];

    /**
     * Parses out the search parameters from a request.
     * Unparsed, they will look like this:
     *    (name:Benjamin Framklin,location:Philadelphia)
     * Parsed:
     *     array('name'=>'Benjamin Franklin', 'location'=>'Philadelphia')
     *
     * @param  string $unParsed Unparsed search string
     *
     * @return array            An array of fieldname=>value search parameters
     */
    protected function parseSearchParameters($unParsed)
    {
        // Strip params that come with the request string
        $unParsed = trim($unParsed, '()');
        // Now we have an array of "key:value" strings.
        $splitFields = explode(',', $unParsed);
        $mapped      = [];
        // Split the strings at their colon, set left to key, and right to value.
        foreach ($splitFields as $field) {
            $splitField             = explode(':', $field);
            $mapped[$splitField[0]] = $splitField[1];
        }

        return $mapped;
    }

    /**
     * Parses out partial fields to return in the response.
     * Unparsed:
     *     (id,name,location)
     * Parsed:
     *     array('id', 'name', 'location')
     *
     * @param  string $unParsed Unparsed string of fields to return in partial response
     *
     * @return array            Array of fields to return in partial response
     */
    protected function parsePartialFields($unParsed)
    {
        return explode(',', trim($unParsed, '()'));
    }

    /**
     * Main method for parsing a query string.
     * Finds search paramters, partial response fields, limits, and offsets.
     * Sets Controller fields for these variables.
     *
     * @param array $allowedFields Allowed fields array for search and partials
     *
     * @return bool Always true if no exception is thrown
     * @throws UnsupportedOperationException
     */
    protected function parseRequest($allowedFields)
    {
        $request      = Yii::$app->getRequest();
        $searchParams = $request->get('q', null);
        $fields       = $request->get('fields', null);
        // Set limits and offset, else wise allow them to have defaults set in the Controller
        $this->limit  = ($request->get('limit', null)) ?: $this->limit;
        $this->offset = ($request->get('offset', null)) ?: $this->offset;
        // If there's a 'q' parameter, parse the fields, then determine that all the fields in the search
        // are allowed to be searched from $allowedFields['search']
        if ($searchParams) {
            $this->isSearch     = true;
            $this->searchFields = $this->parseSearchParameters($searchParams);
            // This handy snippet determines if searchFields is a strict subset of allowedFields['search']
            if (array_diff(array_keys($this->searchFields), $this->allowedFields['search'])) {
                throw new UnsupportedOperationException(
                    "The fields you specified cannot be searched.",
                    401
                );
            }
        }
        // If there's a 'fields' parameter, this is a partial request.  Ensures all the requested fields
        // are allowed in partial responses.
        if ($fields) {
            $this->isPartial     = true;
            $this->partialFields = $this->parsePartialFields($fields);
            // Determines if fields is a strict subset of allowed fields
            if (array_diff($this->partialFields, $this->allowedFields['partials'])) {
                throw new UnsupportedOperationException(
                    "The fields you asked for cannot be returned.",
                    401
                );
            }
        }

        return true;
    }
}
