<?php

namespace Convoy\Repositories\Eloquent;

use Convoy\Models\Server;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Convoy\Exceptions\Repository\RecordNotFoundException;
use Convoy\Contracts\Repository\ServerRepositoryInterface;

class ServerRepository extends EloquentRepository implements ServerRepositoryInterface
{
    public function model(): string
    {
        return Server::class;
    }

    /**
     * Check if a given UUID and UUID-Short string are unique to a server.
     */
    public function isUniqueUuidCombo(string $uuid, string $short): bool
    {
        return ! $this->getBuilder()->where('uuid', '=', $uuid)->orWhere('uuid_short', '=', $short)->exists();
    }

    /**
     * Return a server by UUID.
     *
     * @throws RecordNotFoundException
     */
    public function getByUuid(string $uuid): Server
    {
        try {
            /** @var Server $model */
            $model = $this->getBuilder()
                ->where(function (Builder $query) use ($uuid) {
                    $query->where('uuid_short', $uuid)->orWhere('uuid', $uuid);
                })
                ->firstOrFail($this->getColumns());

            return $model;
        } catch (ModelNotFoundException $exception) {
            throw new RecordNotFoundException();
        }
    }
}
