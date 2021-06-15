@if ($filtersView || count($customFilters))
    <div  class="btn-group d-block d-md-inline">
        <button type="button" class="btn dropdown-toggle d-block w-100 d-md-inline" data-bs-toggle="dropdown">
            @lang('Filters')

            <span id="filter-count-badge" class="badge badge-info {{count($this->getFiltersWithoutSearch()) ? '':'d-none'}}">
                {{count($this->getFiltersWithoutSearch())}}
            </span>

            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu w-100" role="menu">
            <li>
                @if ($filtersView)
                    @include($filtersView)
                @elseif (count($customFilters))
                    @foreach ($customFilters as $key => $filter)
                        <div wire:key="filter-{{ $key }}" class="p-2">
                            <label for="filter-{{ $key }}" class="mb-2">
                                {{ $filter->name() }}
                            </label>

                            @if ($filter->isSelect())
                                @include('livewire-tables::bootstrap-5.includes.filter-type-select')
                            @elseif($filter->isDate())
                                @include('livewire-tables::bootstrap-5.includes.filter-type-date')
                            @endif
                        </div>
                    @endforeach
                @endif

                <div id="filter-clear-button"
                     class="{{count($this->getFiltersWithoutSearch()) ? '':'d-none'}}">
                    <div class="dropdown-divider"></div>

                    <button
                        wire:click.prevent="resetFilters"
                        class="dropdown-item btn"
                    >
                        @lang('Clear')
                    </button>
                </div>
            </li>
        </ul>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.on('updateFiltersCount', count => {
            if (count > 0) {
                $("#filter-count-badge").removeClass('d-none').text(count);
                $("#filter-clear-button").removeClass('d-none');
            } else {
                $("#filter-count-badge").addClass('d-none');
                $("#filter-clear-button").addClass('d-none');
            }
        })
    });
</script>
