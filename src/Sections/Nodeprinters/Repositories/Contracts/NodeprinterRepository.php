<?php

namespace AwemaPL\Printer\Sections\Nodeprinters\Repositories\Contracts;

use Illuminate\Http\Request;

interface NodeprinterRepository
{
    /**
     * Create nodeprinter
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Scope nodeprinter
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);
    
    /**
     * Update nodeprinter
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);
    
    /**
     * Delete nodeprinter
     *
     * @param int $id
     */
    public function delete($id);

    /**
     * Select nodeprinter
     *
     * @param string $apiKey
     */
    public function select($apiKey);

}
