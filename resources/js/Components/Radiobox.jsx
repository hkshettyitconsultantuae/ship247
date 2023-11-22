export default function radio({ className = '', ...props }) {
    return (
        <input
            {...props}
            type="radio"
            className={
                'form-radio ' +
                className
            }
        />
    );
}
