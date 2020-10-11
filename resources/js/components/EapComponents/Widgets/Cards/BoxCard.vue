<template>
  <div
    class="card"
    :class="[
            { [`text-${align}`]: align },
            { [`h-${height}`]: height },
            cardClasses
        ]"
  >
    <div class="card-body">
      <h5 v-if="title" class="card-title w-100">{{ title }}</h5>
      <div v-if="$slots.title">
        <slot name="title"></slot>
      </div>
      <h6 v-if="subTitle" class="card-subtitle mb-2 text-muted w-100 float-left">{{ subTitle }}</h6>
      <div v-if="$slots.subTitle">
        <slot name="subTitle"></slot>
      </div>

      <div class="card-text">
        <div v-if="contentText" v-html="contentText"></div>
        <slot v-if="!loading"></slot>
        <slot name="loading">
          <i v-if="loading" class="fas fa-spinner fa-spin"></i>
        </slot>
      </div>

      <!--<a href="#" class="card-link">Card link</a>
      <a href="#" class="card-link">Another link</a>-->
    </div>
  </div>
</template>
<script>
export default {
  props: {
    loading: {
      type: Boolean,
      default: false
    },
    title: {
      type: [String, Number],
      description: "Card Title"
    },
    height: {
      type: Number,
      description: "Card Height (100%, 75%, 50%, 25%)"
    },
    align: {
      type: String,
      default: "left",
      description: "center, left, right"
    },
    subTitle: {
      type: [String, Number],
      description: "Card Sub Title"
    },
    contentText: {
      type: [String, Number],
      description: "Card Text"
    },
    cardClasses: {
      type: [String, Object, Array],
      description: "Card css classes"
    }
  }
};
</script>
<style scoped lang="scss">
.card {
  border-radius: 10px !important;
}
</style>
