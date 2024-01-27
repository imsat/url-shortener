import Swal from 'sweetalert2'

const alert = (options) => {
    Swal.fire(options)
}

export const alertSuccess = ({title = "Success!", text = "That's all done!", timer = 1000, showConfirmationButton = false} = {}) => {
    alert({
        title: title,
        text: text,
        timer: timer,
        showConfirmButton: showConfirmationButton,
        icon: 'success'
    })
}

export const alertError = ({title = "Error!", text = "Oops...Something went wrong"} = {}) => {
    alert({
        title: title,
        text: text,
        icon: 'error'
    })
}

export const confirm = (title = null, text) => {
    return Swal.fire({
        title: title || 'Are you sure?',
        text: text || 'You will not be able to revert this action!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    });
}

export const successToast = (msg, options) => {
    options = Object.assign({
        toast: true,
        icon: 'success',
        title: msg,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
    Swal.fire(options)
}

export const errorToast = (msg, options, timer= 3000) => {
    options = Object.assign({
        toast: true,
        icon: 'error',
        title: msg,
        position: 'top-end',
        showConfirmButton: false,
        timer: timer,
        timerProgressBar: true,
    })
    Swal.fire(options)
}
