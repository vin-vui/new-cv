// Made with love by Rohan Likhite

<template>
  <button
    :class="[ css, stepsComplete? 'confirmation__button--complete' : '' ]"
    :disabled='stepsComplete'
    v-on:click='incrementStep()'>
      {{ currentMessage }}
  </button>
</template>

<script>
  export default {
    name: 'VueConfirmationButton',
    props: {
      messages: Array,
      css: {
        type: String,
        default: 'confirmation__button'
      },
    },
    data() {
      return {
        defaultSteps: [
          'Click to confirm',
          'Are you sure?',
          '✔',
        ],
        currentStep: 0,
      }
    },
    computed: {
      messageList() {
        return this.messages ? this.messages : this.defaultSteps
      },
      currentMessage() {
        return this.messageList[this.currentStep]
      },
      lastMessageIndex() {
        return this.messageList.length - 1
      },
      stepsComplete() {
        return this.currentStep === this.lastMessageIndex
      }
    },
    methods: {
      incrementStep() {
        this.currentStep++
        if (this.stepsComplete) {
          this.$emit('confirmation-success')
        }
        else {
          this.$emit('confirmation-incremented')
        }
      },
      reset() {
        this.currentStep = 0
        this.$emit('confirmation-reset')
      },
    },
  }
</script>

<style>
  .confirmation__button {
    display: block;
    outline: 0;
    cursor: pointer;
  }
  .confirmation__button.confirmation__button--complete {
    cursor: not-allowed;
    background: transparent;
    /* color: #fff; */
    min-width: 50px;
    padding: 0em;
    font-size: 1em;
    /* box-shadow: 0px 6px 54px rgba(104,160,106,0.5); */
    /* animation: icon-pop 0.3s linear 1; */
  }
  @keyframes icon-pop {
      0%   {font-size: 0.1em;}
      50%  {font-size: 1.8em;}
  }
</style>
