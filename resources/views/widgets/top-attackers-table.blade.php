<x-filament-widgets::widget>
    <x-filament::section heading="{{ __('filament-security::messages.event_log.charts.top_attackers') }}">
        @php
            $attackers = $this->getAttackers();
        @endphp

        @if($attackers->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-success-50 dark:bg-success-500/10 mb-4">
                    <x-filament::icon
                        icon="heroicon-o-shield-check"
                        class="h-6 w-6 text-success-500"
                    />
                </div>
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">
                    {{ __('filament-security::messages.event_log.charts.no_threats') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('filament-security::messages.event_log.charts.no_threats_description') }}
                </p>
            </div>
        @else
            <div class="fi-ta">
                <div class="fi-ta-content overflow-x-auto">
                    <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 dark:divide-white/5">
                        <thead class="bg-gray-50 dark:bg-white/5">
                            <tr>
                                <th class="fi-ta-header-cell px-4 py-3 text-start text-sm font-semibold text-gray-950 dark:text-white">
                                    IP
                                </th>
                                <th class="fi-ta-header-cell px-4 py-3 text-start text-sm font-semibold text-gray-950 dark:text-white">
                                    {{ __('filament-security::messages.event_log.table.location') }}
                                </th>
                                <th class="fi-ta-header-cell px-4 py-3 text-center text-sm font-semibold text-gray-950 dark:text-white">
                                    {{ __('filament-security::messages.event_log.charts.events') }}
                                </th>
                                <th class="fi-ta-header-cell px-4 py-3 text-center text-sm font-semibold text-gray-950 dark:text-white">
                                    {{ __('filament-security::messages.event_log.charts.types') }}
                                </th>
                                <th class="fi-ta-header-cell px-4 py-3 text-start text-sm font-semibold text-gray-950 dark:text-white whitespace-nowrap">
                                    {{ __('filament-security::messages.event_log.charts.last_seen') }}
                                </th>
                                <th class="fi-ta-header-cell px-4 py-3 text-center text-sm font-semibold text-gray-950 dark:text-white">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                            @foreach($attackers as $attacker)
                                <tr class="fi-ta-row hover:bg-gray-50 dark:hover:bg-white/5 transition {{ $loop->even ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                                    <td class="fi-ta-cell px-4 py-3">
                                        <x-filament::badge
                                            :color="$attacker->is_banned ? 'danger' : 'gray'"
                                            x-on:click="navigator.clipboard.writeText('{{ $attacker->ip_address }}')"
                                            class="cursor-pointer"
                                            title="Click to copy"
                                        >
                                            {{ $attacker->ip_address }}
                                        </x-filament::badge>
                                    </td>
                                    <td class="fi-ta-cell px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        @if($attacker->country)
                                            {{ \WallaceMartinss\FilamentSecurity\Filament\Resources\SecurityEventResource\Widgets\TopAttackersTable::countryFlag($attacker->country) }}
                                            {{ $attacker->country }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="fi-ta-cell px-4 py-3 text-center">
                                        <x-filament::badge
                                            :color="$attacker->events_count > 20 ? 'danger' : ($attacker->events_count > 5 ? 'warning' : 'gray')"
                                        >
                                            {{ $attacker->events_count }}
                                        </x-filament::badge>
                                    </td>
                                    <td class="fi-ta-cell px-4 py-3 text-center">
                                        <x-filament::badge color="info">
                                            {{ $attacker->types_count }}
                                        </x-filament::badge>
                                    </td>
                                    <td class="fi-ta-cell px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($attacker->last_seen)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="fi-ta-cell px-4 py-3 text-center">
                                        @if($attacker->is_banned)
                                            <x-filament::badge color="danger" icon="heroicon-o-no-symbol">
                                                {{ __('filament-security::messages.event_log.charts.banned') }}
                                            </x-filament::badge>
                                        @else
                                            <x-filament::badge color="gray">
                                                {{ __('filament-security::messages.event_log.charts.active') }}
                                            </x-filament::badge>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
