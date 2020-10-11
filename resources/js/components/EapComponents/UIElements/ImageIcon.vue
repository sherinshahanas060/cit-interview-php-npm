<template>
    <router-link class="icon-link" to="">
        <slot>
            <div class="headshot" :class="[{ [`size-${size}`]: size }]">
                <img :title="title" :src="src" :class="imageClasses" alt />
            </div>
        </slot>
        <slot name="label">
            <label v-if="label" :class="labelClasses">{{ label }}</label>
        </slot>
    </router-link>
</template>

<script>
export default {
    props: {
        // "`/file?name=profile/${name}&disk=user_uploads`"

        src: {
            type: String,
            description: "Url from outside of eap"
        },
        title: {
            type: String,
            default: "User Image",
            description: "Title attribute for image"
        },
        imageClasses: {
            type: [String, Object, Array],
            description: "css classes"
        },
        labelClasses: {
            type: [String, Object, Array],
            description: "Name label css classes"
        },
        label: {
            type: String,
            description: "Name label (text before image)"
        },
        size: {
            type: String,
            description: "Icon size (xs, sm, lg)",
            default: "xs"
        }
    }
};
</script>

<style lang="scss">
.icon-link {
    float: left;
    text-align: center;
}
.size-xs {
    height: 40px;
    width: 40px;
}
.headshot {
    flex-shrink: 0;
    background-origin: border-box;
    background-clip: content-box, border-box;
    background-size: cover;
    box-sizing: border-box;
    border: 2px solid #efefef;
    border-radius: 50%;
    background-image: linear-gradient(
        to bottom right,
        #ff3cac,
        #562b7c,
        #2b86c5
    );
    overflow: hidden;
    img {
        background-color: #fff;
        // padding: 2px;
        min-width: auto;
        height: 100%;
        min-height: 100%;
        width: auto;
        max-width: unset;
        max-height: unset;
    }
}
// .profile-img-ico {
//     background: linear-gradient(to right, red, purple);
//     border: calc(8px + 0.2vw) solid transparent;
//     img {
//         min-width: auto;
//         height: 100%;
//         min-height: 100%;
//         width: auto;
//         max-width: unset;
//         max-height: unset;
//     }
// }
</style>
