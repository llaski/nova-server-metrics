<template>
    <card class="h-auto p-4">
        <h2 class="text-90 font-light mb-4">Server Metrics</h2>

            <loader v-if="initialLoading" class="mb-4"></loader>

            <table v-if="!initialLoading" class="table w-full">
                <tbody>
                    <tr>
                        <td><span class="font-semibold">Disk Space</span></td>
                        <td>
                            <span>{{ metrics.disk_usage.use_percentage}}% Used ({{ metrics.disk_usage.used_space }}<span class="text-xs">{{  metrics.disk_usage.unit.toLowerCase() }}</span> / {{ metrics.disk_usage.total_space }}<span class="text-xs">{{  metrics.disk_usage.unit.toLowerCase() }}</span>)</span>
                        </td>
                    </tr>
                    <tr v-if="metrics.memory_usage">
                        <td><span class="font-semibold">Memory Usage</span></td>
                        <td>
                            <span>{{ metrics.memory_usage.use_percentage}}% Used ({{ metrics.memory_usage.used_memory }}<span class="text-xs">{{  metrics.memory_usage.unit.toLowerCase() }}</span> / {{ metrics.memory_usage.total_memory }}<span class="text-xs">{{  metrics.memory_usage.unit.toLowerCase() }}</span>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="font-semibold">CPU Usage</span></td>
                        <td><span>{{ metrics.cpu_usage.use_percentage}}% Used</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </card>
</template>

<script>
export default {

    props: ['card'],

    data: () => ({
        initialLoading: true,
        metrics: {},
    }),

    mounted() {
        this.fetchMetrics()
    },

    methods: {

        fetchMetrics() {
            Nova.request().get('/nova-vendor/nova-server-metrics/metrics').then((response) => {
                this.initialLoading = false
                this.metrics = response.data

                //Update every second
                setTimeout(this.fetchMetrics, 3 * 1000)
            })
        },

        formatNumber(value) {
            if (!value) {
                return 0;
            }

            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
        }

    }
}
</script>
