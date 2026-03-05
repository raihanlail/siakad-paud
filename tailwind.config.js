import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    safelist: [
    'bg-blue-500',   'bg-blue-50',    'border-blue-200',   'bg-blue-100',   'text-blue-700',
    'bg-violet-500', 'bg-violet-50',  'border-violet-200', 'bg-violet-100', 'text-violet-700',
    'bg-emerald-500','bg-emerald-50', 'border-emerald-200','bg-emerald-100','text-emerald-700',
    'bg-amber-500',  'bg-amber-50',   'border-amber-200',  'bg-amber-100',  'text-amber-700',
    'bg-rose-500',   'bg-rose-50',    'border-rose-200',   'bg-rose-100',   'text-rose-700',
    'bg-slate-500',  'bg-slate-50',   'border-slate-200',  'bg-slate-100',  'text-slate-700',
  ],

    plugins: [forms],
};
