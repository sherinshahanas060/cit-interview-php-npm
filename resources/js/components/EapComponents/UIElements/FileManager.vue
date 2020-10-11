<template>
    <div>
        <slot>
            <div>
                <i
                    class="fa fa-times-circle"
                    @click="deleteAttachment(attachment.id, index, docIndex)"
                ></i>
                <a href="#" @click="$filePreview(mime, url, disk)">
                    <img
                        class="attachment-icon"
                        :src="$getAttachmentTemp(mime)"
                    />
                </a>
            </div>
        </slot>
        <slot name="label">
            <label class="w-100 text-center">{{
                attachment.attachment | getFileName
            }}</label>
        </slot>
    </div>
</template>
<script>
export default {
    props: {
        attachment: {
            type: [Array],
            description: "File details"
        },
        drive: {
            type: String,
            description: "Disk name"
        },
        url: {
            type: String,
            description: "Url for file"
        },
        mime: {
            type: String,
            description: "Extenction of file"
        },
        removeUrl: {
            type: String,
            description: "url for remove from database",
            default: null
        },
        hasRemove: {
            type: Boolean,
            description: "show remove icon",
            default: false
        },
        autoRemove: {
            type: Boolean,
            description: "is remove by external function",
            default: false
        },
        key: {
            type: Number,
            description: "Index of file"
        }
    },
    methods: {
        deleteAttachment() {
            if (this.hasRemove && this.autoRemove) {
                swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    // Send request to the server
                    if (result.value) {
                        axios
                            .delete(this.removeUrl)
                            .then(response => {
                                if (response.data.status == 101) {
                                    //   this.form.documentDetails[index].attachment_count.splice(docIndex, 1);
                                    this.$emit("removed", response.data.data);
                                } else {
                                    swal.fire(
                                        "Failed!",
                                        "There was something wrong.",
                                        "warning"
                                    );
                                }
                            })
                            .catch(() => {
                                swal.fire(
                                    "Failed!",
                                    "There was something wrong.",
                                    "warning"
                                );
                            });
                    }
                });
            } else if (this.hasRemove) {
                this.$emit("removed", true);
            }
        }
    }
};
</script>
