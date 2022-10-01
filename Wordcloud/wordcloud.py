#!py -m pip install wordcloud
#!py -m pip install fileupload
#!py -m pip install ipywidgets
#!py -m jupyter nbextension install --py --user fileupload
#!py -m jupyter nbextension enable --py fileupload

import wordcloud
import numpy as np
from matplotlib import pyplot as plt
from IPython.display import display
import fileupload
import io
import sys

def _upload():

    _upload_widget = fileupload.FileUploadWidget()

    def _cb(change):
        global file_contents
        decoded = io.StringIO(change['owner'].data.decode('utf-8'))
        filename = change['owner'].filename
        print('Uploaded `{}` ({:.2f} kB)'.format(
            filename, len(decoded.read()) / 2 **10))
        file_contents = decoded.getvalue()

    _upload_widget.observe(_cb, names='data')
    display(_upload_widget)

_upload()

def calculate_frequencies(file_contents):
    # Here is a list of punctuations and uninteresting words you can use to process your text
    punctuations = '''!()-[]{};:'"\,<>./?@#$%^&*_~'''
    uninteresting_words = ["the", "a", "to", "if", "is", "it", "of", "and", "or", "an", "as", "i", "me", "my", \
    "we", "our", "ours", "you", "your", "yours", "he", "she", "him", "his", "her", "hers", "its", "they", "them", \
    "their", "what", "which", "who", "whom", "this", "that", "am", "are", "was", "were", "be", "been", "being", \
    "have", "has", "had", "do", "does", "did", "but", "at", "by", "with", "from", "here", "when", "where", "how", \
    "all", "any", "both", "each", "few", "more", "some", "such", "no", "nor", "too", "very", "can", "will", "just"]
    
    # LEARNER CODE START HERE
    my_dict = {}
    file_punct = file_contents.split()
   
    #split & check for punctuation

    for i, x in enumerate (file_punct):
        for y in punctuations:
            if x.find(y) != -1 :
                file_punct[i] = x.replace(y, '')
        
    file_alpha = []
    
    for z in file_punct:
        if z.isalpha():
            file_alpha.append(z.lower())
            
    for w in file_alpha:
        if w not in uninteresting_words:
            if w not in my_dict.keys():
                my_dict[w] = 1
            else:
                t = my_dict[w]
                t += 1
                my_dict[w] = t
                
    
    cloud = wordcloud.WordCloud()
    cloud.generate_from_frequencies(my_dict)
    return cloud.to_array()


myimage = calculate_frequencies(file_contents)
plt.imshow(myimage, interpolation = 'nearest')
plt.axis('off')
plt.show()