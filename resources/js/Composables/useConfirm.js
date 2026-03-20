import {router} from '@inertiajs/vue3'
import Swal from "sweetalert2";
import {useTrans} from "./useTrans.js";

export function useConfirm() {
    const {t} = useTrans();

    return (url, options = {}) => {
        Swal.fire({
            title: options.title || t('admin.messages.confirm_title'),
            text: options.text || t('admin.messages.confirm_text'),
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: options.confirmButtonColor || '#d33',
            cancelButtonColor: options.cancelButtonColor || '#3085d6',
            confirmButtonText: options.confirmButtonText || t('admin.messages.confirm_button'),
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(url)
            }
        })
    }
}
