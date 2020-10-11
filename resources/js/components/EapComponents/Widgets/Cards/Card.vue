<template>
    <div
        class="card"
        :class="[
            { 'card-lift--hover': hover },
            { shadow: shadow },
            { [`shadow-${shadowSize}`]: shadowSize },
            { [`bg-gradient-${gradient}`]: gradient },
            { [type]: type },
            { [`rounded-${rounded}`]: rounded },
            cardClasses
        ]"
    >
        <div
            class="card-header pt-4 pb-4 row m-0 bg-white"
            :class="headerClasses"
            v-if="$slots.header"
        >
            <slot name="header"> </slot>
        </div>
        <div
            class="card-body view-type m-0"
            :class="[{ 'p-0': (type == 'av-datatable') }, bodyClasses]"
            v-if="!noBody"
        >
            <slot></slot>
        </div>

        <slot v-if="noBody"></slot>

        <div
            class="card-footer bg-white"
            :class="footerClasses"
            v-if="$slots.footer"
        >
            <slot name="footer"></slot>
        </div>
    </div>
</template>
<script>
export default {
    name: "card",
    props: {
        type: {
            type: String,
            default: "default-card",
            description: "Card type"
        },
        gradient: {
            type: String,
            description: "Card background gradient type (warning,danger etc)"
        },
        hover: {
            type: Boolean,
            description: "Whether card should move on hover"
        },
        shadow: {
            type: Boolean,
            description: "Whether card has shadow"
        },
        shadowSize: {
            type: String,
            description: "Card shadow size"
        },
        noBody: {
            type: Boolean,
            default: false,
            description: "Whether card should have wrapper body class"
        },
        bodyClasses: {
            type: [String, Object, Array],
            description: "Card body css classes"
        },
        cardClasses: {
            type: [String, Object, Array],
            description: "Card css classes"
        },
        headerClasses: {
            type: [String, Object, Array],
            description: "Card header css classes"
        },
        footerClasses: {
            type: [String, Object, Array],
            description: "Card footer css classes"
        },
        rounded: {
            type: String,
            description: "Card rounded shapes"
        }
    }
};
</script>
<style lang="scss" scoped>
.default-card {
    .card-header {
        // background: #fff;
        .card-title {
            font-size: 17px;
            p {
                width: 100%;
                font-size: 12px;
                color: #868585;
            }
        }
    }
}
.control-side-page {
    .card {
        border: 0px;
        background-color: #F4F6F9;
        box-shadow: none;
        .card-header {
            padding-top: 3rem !important;
            padding-bottom: 1rem !important;
            background-color: #F4F6F9 !important;
            border-bottom: 0px;
            h3 {
                font-family: font-Black;
                font-size: 30px;
                color: #938D8D;
            }
        }
    }
}
</style>
