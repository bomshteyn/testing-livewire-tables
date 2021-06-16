<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class UsersTable extends DataTableComponent
{
    public $users;

    protected $listeners = ['refreshUsersTable' => '$refresh'];

    public array $bulkActions = [
        'activate' => 'Activate',
        'deactivate' => 'Deactivate',
    ];

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
            Column::make('Active')
                  ->sortable(),
            Column::make('Verified', 'email_verified_at')
                  ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            'userName' => Filter::make('User Name')
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

    public function query()
    {
        return User::query();
    }

    public function activate()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            User::whereIn('id', $this->selectedKeys())
                ->update(['active' => true]);
        }
        $this->emit('refreshUsersTable');
    }

    public function deactivate()
    {
        if ($this->selectedRowsQuery->count() > 0) {
            User::whereIn('id', $this->selectedKeys())
                ->update(['active' => false]);
        }
        $this->emit('refreshUsersTable');
    }
}
