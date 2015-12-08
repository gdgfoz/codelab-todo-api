<?php

namespace GDGFoz\Hooks\ResponseFractal;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\SerializerAbstract;


class ResponseFractal
{
    protected $statusCode = 200;

    const CODE_WRONG_ARGS = 'WRONG_ARGS';
    const CODE_NOT_FOUND = 'NOT_FOUND';
    const CODE_INTERNAL_ERROR = 'INTERNAL_ERROR';
    const CODE_UNAUTHORIZED = 'UNAUTHORIZED';
    const CODE_FORBIDDEN = 'FORBIDDEN';
    const CODE_INVALID_MIME_TYPE = 'INVALID_MIME_TYPE';

    /**
     * @var \League\Fractal\Manager
     */
    protected $manager;

    /**
     * @var Request
     */
    private $request;

    public function __construct(SerializerAbstract $serializer, Request $request)
    {
        $this->request = $request;

        $this->manager = new Manager();
        $this->manager->setSerializer($serializer);

        $this->parseIncludes( $this->request->get('include') );
    }

    public function parseIncludes($includes)
    {
        if( ! empty($includes) )
            $this->manager->parseIncludes($includes);
    }


    /**
     * Getter for statusCode
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param mixed $data
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return array
     */
    public function respondItem($data, $transformer = null, $resourceKey = null, $onFail = true)
    {
        if($onFail === true && is_null($data) ){
            return $this->errorNotFound();
        }

        $resource = new Item($data, $this->getTransformer($transformer), $resourceKey);
        $rootScope = $this->fractal->createData($resource)->toArray();

        return $this->respondWithArray($rootScope);
    }

    /**
     * @param $data
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return array
     */
    public function respondCollection($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Collection($data, $this->getTransformer($transformer), $resourceKey);
        $rootScope= $this->manager->createData($resource)->toArray();

        return $this->respondWithArray($rootScope);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param \League\Fractal\TransformerAbstract|\Closure $transformer
     * @param string $resourceKey
     * @return mixed
     */
    public function respondPaginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null)
    {
        $paginator->appends($this->request->query());
        $resource = new Collection($paginator->items(), $this->getTransformer($transformer), $resourceKey);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope =  $this->manager->createData($resource)->toArray();
        return $this->respondWithArray($rootScope);
    }


    public function respondCreateItemSucess($item, $callback, $msg = "Registrado com sucesso!")
    {
        $this->statusCode =  201;
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);
        $data = $rootScope->toArray();
        $data['message'] = $msg;
        return $this->respondWithArray($data);
    }

    public function respondUpdateItemSucess($item, $callback, $msg = "Atualizado com sucesso!")
    {
        $this->statusCode =  200;
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);
        $data = $rootScope->toArray();
        $data['message'] = $msg;
        return $this->respondWithArray($data);
    }

    /**
     * Resposta customizada de erro
     * @param $message
     * @param $errorCode
     * @param null $validation
     * @return mixed
     */
    public function respondCustomError($message, $errorCode, $validation = null)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "Erro interno, não especificado o codigo do status em respondCustomError.",
                E_USER_WARNING
            );
        }

        return $this->respondWithArray([
            'status'=> 'error',
            'error' => [
                'code' => $errorCode,
                'http_code' => $this->statusCode,
                'message' => $message,
                'validation' => $validation
            ]
        ]);
    }

    /**
     * Padrão de retorno das requisições
     * @param string $message mensagem de resposta
     * @param booleam $status error/success
     * @param array $erros Validation
     */
    public function respondRespondStatus($message, $status = true, $data = array(), $erros = array() )
    {
        if( $status === true)
        {
            $data = [
                'status' => 'success',
                'message' => $message,
                'data' => $data
            ];

            return $this->respondWithArray($data);
        }

        return $this->respondCustomError($message, 405, $erros);
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondEForbidden($message = 'Não autorizado, sem permissão de acesso')
    {
        return $this->setStatusCode(403)->respondCustomError($message, self::CODE_FORBIDDEN);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondEInternalError($message = 'Erro interno de servidor, desculpe :( ')
    {
        return $this->setStatusCode(500)->respondCustomError($message, self::CODE_INTERNAL_ERROR);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondENotFound($message = 'Não encontrado')
    {
        return $this->setStatusCode(404)->respondCustomError($message, self::CODE_NOT_FOUND);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondEUnauthorized($message = 'Não logado')
    {
        return $this->setStatusCode(401)->respondCustomError($message, self::CODE_UNAUTHORIZED);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @param array $validation MessageBag validation
     * @param string $message frase do erro
     * @param string $code padrão WRONG_ARGS
     * @return \Illuminate\Http\Response
     */
    public function respondErrorWrongArgs($validation = null, $message = 'Erro de validação', $code = null)
    {
        $code = (is_null($code))? self::CODE_WRONG_ARGS : $code;
        return $this->setStatusCode(400)->respondCustomError($message, $code, $validation);
    }


    public function respondWithArray(array $array, array $headers = [])
    {

        $mimeType = 'application/json';

        switch ($mimeType) {

            case 'application/json':
                $contentType = 'application/json';
                $content = json_encode($array);
                break;

//            case 'application/x-yaml':
//                $contentType = 'application/x-yaml';
//                $dumper = new YamlDumper();
//                $content = $dumper->dump($array, 2);
//                break;

            default:
                $contentType = 'application/json';
                $content = json_encode([
                    'error' => [
                        'code' => static::CODE_INVALID_MIME_TYPE,
                        'http_code' => 415,
                        'message' => sprintf('Content of type %s is not supported.', $mimeType),
                    ]
                ]);
        }

        return response($content, $this->statusCode, $headers)->header('Content-Type', $contentType);
    }

    /**
     * @param TransformerAbstract $transformer
     * @return TransformerAbstract|callback
     */
    protected function getTransformer($transformer = null)
    {
        return $transformer ?: function($data) {
            if($data instanceof Arrayable) {
                return $data->toArray();
            }
            return (array) $data;
        };
    }

}