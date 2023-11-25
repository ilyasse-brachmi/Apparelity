<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { ref } from 'vue';

const props = defineProps({
  labelName: {
    type: String,
    required: true
  },
  color: {
    type: String,
    default: 'black'
  },
  icon: {
    type: String,
    required: false
  },
  type: {
    type: String,
    default: "text"
  }
})
const passwordIcon = ref(props.type !== 'password' ? false : true)
const typeInput = ref(props.type)
const switchType = () => {
  typeInput.value = typeInput.value === 'password' ? 'text' : 'password'
} 
</script>
<template lang="pug">
div(class="conatiner relative leading-normal w-full")
  input(:type="typeInput" class="p-4 outline-none relative w-full text-black bg-transparent duration-100 z-[9999]" required)
  p(class="labelInput z-0 text-lg text-gray-400 px-2 absolute top-4 duration-300 whitespace-pre") {{ props.labelName }}
  Icon(v-if="passwordIcon" icon="ri:eye-off-line" @click="switchType" class="IconColor absolute end-4 top-4 text-3xl z-[999999] cursor-pointer")
  div(v-else)
    Icon(v-if="icon" :icon="icon" class="IconColor absolute end-4 top-4 text-3xl z-[999999] cursor-pointer")
</template>
<style scoped>
input:focus {
  border: 2px solid v-bind(color);
  border-radius: 6px;
}

.IconColor {
  color: v-bind(color);
}


input{
  border-bottom: 2px solid v-bind(color);
}

.labelInput{
 word-spacing: pre-line;

}

input:focus + .container
{
  border: none;
}

input:focus+.labelInput,
input:valid+.labelInput {
  transform: translate(10px, -30px) scale(0.88);
  z-index: 99999;
  background-color: white;
  color: v-bind(color);
}
</style>