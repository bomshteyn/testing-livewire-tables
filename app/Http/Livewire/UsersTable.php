<?php

namespace App\Http\Livewire;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class UsersTable extends DataTableComponent
{

    protected $listeners = ['refreshUsersTable' => '$refresh'];

    public array $bulkActions = [
        'activate'   => 'Activate',
        'deactivate' => 'Deactivate',
    ];

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
                  ->sortable()
                  ->format(function ($value, $column, $row) {
                      return view('tables.cells.boolean',
                          [
                              'boolean' => $value
                          ]
                      );
                  }),
            Column::make('Verified', 'email_verified_at')
                  ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            'verified' => Filter::make('E-mail Verified')
                                ->select([
                                    ''    => 'Any',
                                    'yes' => 'Yes',
                                    'no'  => 'No',
                                ]),
            'active'   => Filter::make('Active')
                                ->select([
                                    ''    => 'Any',
                                    'yes' => 'Yes',
                                    'no'  => 'No',
                                ]),
        ];
    }

    public function query()
    {
        return User::query()
                   ->when($this->getFilter('verified'), function ($query, $verified) {
                       if ($verified === 'yes') {
                           return $query->whereNotNull('verified');
                       }

                       return $query->whereNull('verified');
                   })
                   ->when($this->getFilter('active'), fn($query, $active) => $query->where('active', $active === 'yes'));

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
