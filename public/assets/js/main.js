new Cleave('#no_registrasi_bpjph',{    
    delimiter: '-',
    blocks: [2,1,4,4],    
    uppercase: true
})

new Cleave('.ktp',{    
    delimiter: '-',
    blocks: [16],
    uppercase: true    
})

new Cleave('.npwp',{    
    delimiter: '.',
    blocks: [2,3,3,1,3,3],
    uppercase: true
})

document.querySelectorAll('.number-separator').forEach((item) => {
  item.addEventListener('input', (e) => {
    if (/^[0-9.,]+$/.test(e.target.value)) {
      e.target.value = parseFloat(
        e.target.value.replace(/,/g, '')
      ).toLocaleString('en');
    } else {
      e.target.value = e.target.value.substring(0, e.target.value.length - 1);
    }
  });
});