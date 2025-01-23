<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CurrencyComboBox from '@/Components/CurrencyComboBox.vue'
import { Input } from '@/Components/ui/input/index.js'
import { Button } from '@/Components/ui/button/index.js'
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { ArrowRightLeft, Loader2 } from 'lucide-vue-next'

let props = defineProps({
    currencyCodes: {
        type: Array,
        required: true,
    },
})

const form = useForm({
    fromCurrency: 'usd',
    toCurrency: 'eur',
    amount: 1.00,
})

let currencyListFromCurrency = computed(
    () => props.currencyCodes.filter((currencyCode) => currencyCode.value !== form.toCurrency),
)
let currencyListToCurrency = computed(
    () => props.currencyCodes.filter((currencyCode) => currencyCode.value !== form.fromCurrency),
)

let ratedAmount = ref(null)
let baseFromCurrencyRate = ref(null)
let baseToCurrencyRate = ref(null)

const convert = () => form.transform((data) => ({
    from_currency: data.fromCurrency,
    to_currency: data.toCurrency,
    amount: data.amount,
})).post(
    route('exchange-converter.convert'), {
        onSuccess: (response) => {
            baseFromCurrencyRate.value = response.props.data.baseFromCurrencyRate
            baseToCurrencyRate.value = response.props.data.baseToCurrencyRate
            ratedAmount.value = response.props.data.ratedAmount
        },
    },
)

const revertCurrency = () => {
    const fromCurrency = form.fromCurrency
    form.fromCurrency = form.toCurrency
    form.toCurrency = fromCurrency
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
                            <CurrencyComboBox
                                v-model="form.fromCurrency"
                                :currencies="currencyListFromCurrency"
                                class="h-full w-[150px]"
                            />
                            <CurrencyComboBox
                                v-model="form.toCurrency"
                                :currencies="currencyListToCurrency"
                                class="h-full w-[150px]"
                            />
                            <Button
                                size="icon"
                                variant="outline"
                                class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 rounded-full"
                                @click="revertCurrency"
                            >
                                <ArrowRightLeft />
                            </Button>
                        </div>
                        <Button class="h-full text-center" :disabled="form.processing" @click="convert">
                            <Loader2 v-if="form.processing" class="w-4 h-4 mr-2 animate-spin" />
                            <span>Convert</span>
                        </Button>
                    </div>

                    <div v-if="ratedAmount" class="mt-6 space-y-2">
                        <div class="text-zinc-800 font-medium">{{ form.amount }} {{ form.fromCurrency.toUpperCase() }} =</div>
                        <div class="text-3xl font-medium">{{ ratedAmount }} {{ form.toCurrency.toUpperCase() }}</div>
                        <div class="text-sm text-zinc-600 space-y-1">
                            <div>1 {{ form.fromCurrency.toUpperCase() }} = {{ baseFromCurrencyRate }} {{ form.toCurrency.toUpperCase() }}</div>
                            <div>1 {{ form.toCurrency.toUpperCase() }} = {{ baseToCurrencyRate }} {{ form.fromCurrency.toUpperCase() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
