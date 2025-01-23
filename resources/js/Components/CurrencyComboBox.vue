<script setup>
import { Button } from '@/Components/ui/button'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover/index.js'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/Components/ui/command/index.js'
import { Check, ChevronsUpDown } from 'lucide-vue-next'
import { ref } from 'vue'
import { useForwardPropsEmits } from 'radix-vue'
import { cn } from '@/Utils/cn.js'

let props = defineProps({
    currencies: {
        type: Array,
        required: true,
    },
    class: { type: null, required: false },
})

const open = ref(false)
const value = defineModel()
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="cn('flex justify-between', props.class)"
            >
                <span class="truncate">
                    {{
                        value
                            ? currencies.find((currency) => currency.value === value).label
                            : 'Select currency...'
                    }}
                    </span>

                <ChevronsUpDown class="h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="p-0" side="bottom" align="start">
            <Command>
                <CommandInput placeholder="Change status..." />
                <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem
                            v-for="currency in currencies"
                            :key="currency.value"
                            :value="currency.value"
                            @select="(selected) => {
                              value = selected
                              open = false
                            }"
                        >
                            <span>{{ currency.label }}</span>

                            <Check
                                v-show="value === currency.value"
                                class="ml-auto h-4 w-4"
                            />
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
