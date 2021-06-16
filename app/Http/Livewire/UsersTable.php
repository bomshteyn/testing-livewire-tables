<?php

namespace App\Http\Livewire;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class UsersTable extends DataTableComponent
{
    public $users;

    public $test = [];

    public function mount()
    {
        $this->users = User::query()
                           ->get(['id','name'])
                           ->pluck('name','id')
                           ->toArray();
    }

    public function columns(): array
    {
        return [
            Column::make('Name')
                  ->sortable()
                  ->searchable(),
            Column::make('E-mail', 'email')
                  ->sortable()
                  ->searchable(),
            Column::make('Verified', 'email_verified_at')
                  ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            'active' => Filter::make('User Name')
                              ->select([
                                  '' => 'Any',
                                  ...$this->users
                              ]),
            'verified' => Filter::make('E-mail Verified')
                                ->select([
                                    '' => 'Any',
                                    'yes' => 'Yes',
                                    'no' => 'No',
                                ]),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation
     */
    public function query()
    {
        return User::query();
    }
}
