Then /^I see an updated wordcloud$/ do
    find('#vis').text.should_not eq ''
end

And /^there are two artist names$/ do 
    find('#artistLabel').text.should_not eq ''
end
