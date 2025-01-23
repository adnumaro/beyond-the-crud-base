<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CurrencyComboBox from '@/Components/CurrencyComboBox.vue'
import { Input } from '@/Components/ui/input/index.js'
import { Button } from '@/Components/ui/button/index.js'
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { ArrowRightLeft } from 'lucide-vue-next'

let props = defineProps({
    currencyCodes: {
        type: Array,
        required: true,
    },
})

const form = useForm({
    from: 'usd',
    to: 'eur',
    amount: 1.00,
})

let currencyListFrom = computed(() => props.currencyCodes.filter((currencyCode) => currencyCode.value !== form.to))
let currencyListTo = computed(() => props.currencyCodes.filter((currencyCode) => currencyCode.value !== form.from))

let ratedAmount = ref(null)
let baseFromRate = ref(null)
let baseToRate = ref(null)

const convert = () => form.post(
    route('exchange-converter.convert'), {
        onSuccess: (response) => {
            ratedAmount.value = response.props.data.ratedAmount
            baseFromRate.value = response.props.data.baseFromRate
            baseToRate.value = response.props.data.baseToRate
        },
    },
)

const revertCurrency = () => {
    const from = form.from
    form.from = form.to
    form.to = from
}
</script>

<template>
    <AppLayout title="Exchange converter">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Exchange converter
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="flex w-full max-w-xl items-center gap-1.5 h-12">
                        <Input
                            id="amount"
                            type="number"
                            :min="1.00"
                            placeholder="Amount.."
                            v-model="form.amount"
                            class="h-full w-[150px]"
                        />
                        <div class="relative flex gap-1.5 h-full">
                            <CurrencyComboBox v-model="form.from" :currencies="currencyListFrom" class="h-full w-[150px]" />
                            <CurrencyComboBox v-model="form.to" :currencies="currencyListTo" class="h-full w-[150px]" />
                            <Button
                                size="icon"
                                variant="outline"
                                class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 rounded-full"
                                @click="revertCurrency"
                            >
                                <ArrowRightLeft />
                            </Button>
                        </div>
                        <Button class="h-full" @click="convert">Convert</Button>
                    </div>

                    <div v-if="ratedAmount" class="mt-6 space-y-2">
                        <div class="text-zinc-800 font-medium">{{ form.amount }} {{ form.from.toUpperCase() }} =</div>
                        <div class="text-3xl font-medium">{{ ratedAmount }} {{ form.to.toUpperCase() }}</div>
                        <div class="text-sm text-zinc-600 space-y-1">
                            <div>1 {{ form.from.toUpperCase() }} = {{ baseFromRate }} {{ form.to.toUpperCase() }}</div>
                            <div>1 {{ form.to.toUpperCase() }} = {{ baseToRate }} {{ form.from.toUpperCase() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
